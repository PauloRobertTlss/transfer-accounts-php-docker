<?php declare(strict_types=1);

namespace App\Jobs\Transaction;

use App\Common\ManageRule\ManageRulesInterface;
use App\Common\ManageRule\Types\{NoAllowedShopkeeperRule};
use App\Common\VerifyAuthorization\Exceptions\ServiceOffline;
use App\Domain\CRM\Client\Entity\{ClientInterface,Shopkeeper};
use App\Domain\Financial\Transaction\Request\TransactionRequest;
use App\Models\CRM\Client\ClientModel;
use App\Services\Transaction\Bridge\Workers\{TransactionWorkerP2B, TransactionWorkerP2P};
use App\Services\Transaction\Bridge\{Transaction,TransactionFire};
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

final class CreateTransaction implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var TransactionRequest
     */
    protected TransactionRequest $request;
    /**
     * @var ManageRulesInterface
     */
    private ManageRulesInterface $manageRules;

    /**
     * CreateTransaction constructor.
     * @param TransactionRequest $request
     * @param ManageRulesInterface $manageRules
     */
    public function __construct(TransactionRequest $request, ManageRulesInterface $manageRules)
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

            if ($exception instanceof ServiceOffline) {
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
        $this->manageRules
            ->pushRule(NoAllowedShopkeeperRule::class)
            ->parseRules($clientPayer);
    }

    /**
     * @param ClientInterface $clientPayee
     * @return Transaction
     */
    private function targetTaskTransaction(ClientInterface $clientPayee): Transaction
    {
        if ($clientPayee->document() instanceof Shopkeeper) {
            return resolve(TransactionWorkerP2B::class);
        }

        return resolve(TransactionWorkerP2P::class);
    }
}
