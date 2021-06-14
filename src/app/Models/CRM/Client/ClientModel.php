<?php declare(strict_types=1);

namespace App\Models\CRM\Client;

use App\Domain\CRM\Client\Entity\ClientInterface;
use App\Domain\Financial\BankAccount\Entity\Contract\BankAccountInterface;
use App\Models\Financial\BankAccount\BankAccountModel;
use Illuminate\Database\Eloquent\Model;

class ClientModel extends Model implements ClientInterface
{
    protected string $table = 'clients';
    protected string $keyType = 'string';
    public bool $timestamps = false;

    protected array $fillable = [
        'id',
        'name',
        'document_type',
        'document_id'
    ];

    protected array $casts = [
        'id' => 'string'
    ];

    public function getDocument()
    {
        return $this->document;
    }

    public function document()
    {
        return $this->morphTo('document');
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function uuid(): string
    {
        return $this->id;
    }

    /**
     * @return BankAccountInterface
     */
    public function getBankAccount(): BankAccountInterface
    {
        return $this->bankAccount;
    }

    public function bankAccount()
    {
        return $this->hasOne(BankAccountModel::class, 'client_id')->withDefault(function () {
            return new BankAccountModel();
        });
    }
}
