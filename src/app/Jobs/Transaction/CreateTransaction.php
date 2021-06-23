<?php declare(strict_types=1);

namespace App\Jobs\Transaction;

use App\Common\ManageRule\ManageRulesInterface;
use App\Domain\CRM\Client\Entity\ClientInterface;
use App\Domain\CRM\Client\Entity\ShopkeeperInterface;
use App\Domain\Financial\Transaction\Request\TransactionRequestInterface;
use App\Models\CRM\Client\ClientModel;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use App\Services\Transaction\Bridge\{TransactionFire, TransactionInterface};
use App\Services\Transaction\Bridge\Workers\{TransactionWorkerP2B, TransactionWorkerP2P};
use App\Common\ManageRule\Types\{NoAllowedShopkeeperRule};
use App\Common\VerifyAuthorization\Exceptions\ServiceOfflineException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateTransaction implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var TransactionRequestInterface
     */
    public $request;
    /**
     * @var ManageRulesInterface
     */
    private ManageRulesInterface $manageRules;

    /**
     * CreateTransaction constructor.
     * @param TransactionRequestInterface $request
     * @param ManageRulesInterface $manageRules
     */
    public function __construct(TransactionRequestInterface $request, ManageRulesInterface $manageRules)
    {
        $this->request = $request;
        $this->manageRules = $manageRules;
    }

    /**
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        Log::info('Started queue ' . env('APP_NAME'));

        $clientPayee = ClientModel::find($this->request->payer());
        $this->assertRules($clientPayee);
        $typeTransaction = $this->targetTaskTransaction($clientPayee);

        try {
            (new TransactionFire($this->request))->work($typeTransaction);
        } catch (\Exception $exception) {

            if ($exception instanceof ServiceOfflineException) {
                $this->release(2);
                Log::error('Job service grant . ' . env('APP_NAME') . '  offline ', debug_backtrace(3));
                return true;
            }

            Log::error('Job transaction . ' . env('APP_NAME') . '  error critical ', debug_backtrace(3));
            throw $exception;
        }

        return ['message' => true];

    }

    /**
     * @param ClientInterface $clientPayer
     * @throw \Exception
     */
    private function assertRules(ClientInterface $clientPayer): void
    {
        /** @var ClientModel $clientPayee */
        $this->manageRules->pushRule(NoAllowedShopkeeperRule::class)
            ->parseRules($clientPayer);

    }

    /**
     * @param ClientInterface $clientPayee
     * @return TransactionInterface
     */
    private function targetTaskTransaction(ClientInterface $clientPayee): TransactionInterface
    {
        $document = $clientPayee->document();
        if ($document instanceof ShopkeeperInterface) {
            return resolve(TransactionWorkerP2B::class);
        }

        return resolve(TransactionWorkerP2P::class);
    }
}
