<?php declare(strict_types=1);

namespace App\Models\Financial\BankAccount;

use App\Domain\CRM\Client\Entity\ClientInterface;
use App\Domain\Financial\BankAccount\Entity\Contract\BankAccount;
use App\Models\CRM\Client\ClientModel;
use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

final class BankAccountModel extends Model implements BankAccount
{
    protected string $table = self::TABLE;
    public bool $timestamps = false;

    protected array $casts = [
        'balance' => 'float',
        'client_id' => 'string'
    ];

    protected array $fillable = [
        'agency',
        'account',
        'balance',
        'client_id'
    ];

    public function id(): int
    {
        return $this->id;
    }

    public function getClient(): ClientInterface
    {
        return $this->client;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAgency(): string
    {
        return $this->agency;
    }

    public function getAccount(): string
    {
        return $this->account;
    }

    public function getBalance(): float
    {
        return $this->balance;
    }

    public function client()
    {
        return $this->belongsTo(ClientModel::class);
    }
}
