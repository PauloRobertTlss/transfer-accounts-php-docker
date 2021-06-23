<?php declare(strict_types=1);

namespace App\Models\Financial\Transaction;

use App\Domain\CRM\Client\Entity\ClientInterface;
use App\Domain\Financial\BankAccount\Entity\Contract\BankAccountInterface;
use App\Domain\Financial\Transaction\Entity\Contract\TransactionInterface;
use App\Models\CRM\Client\ClientModel;
use App\Models\Financial\BankAccount\BankAccountModel;
use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

abstract class AbstractTransaction extends Model implements TransactionInterface
{
    use Uuid;

    public bool $timestamps = false;

    protected array $casts = [
        'value' => 'float'
    ];

    protected array $fillable = [
        'id',
        'value',
        'category',
        'bank_account_id',
        'client_done_id'
    ];
    /**
     * @var mixed
     */
    private $value;
    /**
     * @var mixed
     */
    private $bankAccount;
    /**
     * @var mixed
     */
    private $client;

    public function uuid(): string
    {
        return $this->id;
    }

    public function createdAt(): Carbon
    {
        return $this->created_at;
    }

    public function getValue(): float
    {
        return (float)$this->value;
    }

    public function getBankAccount(): BankAccountInterface
    {
        return $this->bankAccount;
    }

    public function getClient(): ClientInterface
    {
        return $this->client;
    }

    public function bankAccount()
    {
        return $this->belongsTo(BankAccountModel::class, 'bank_account_id', 'id')
            ->withDefault(new BankAccountModel());
    }

    public function client()
    {
        $this->belongsTo(ClientModel::class, 'client_done_id', 'id');
    }

}
