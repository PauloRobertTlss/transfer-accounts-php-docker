<?php declare(strict_types=1);

namespace App\Models\CRM\Client;

use App\Domain\CRM\Client\Entity\ClientInterface;
use App\Domain\Financial\BankAccount\Entity\Contract\BankAccount;
use App\Models\Financial\BankAccount\BankAccountModel;
use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

final class ClientModel extends Model implements ClientInterface
{
    use Uuid;

    protected $table = self::TABLE;
    protected $keyType = 'string';
    public $timestamps = false;
    public  $incrementing = false;

    protected  $fillable = [
        'id',
        'name',
        'document_type',
        'document_id'
    ];

    protected $casts = [
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
     * @return BankAccount
     */
    public function getBankAccount(): BankAccount
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
