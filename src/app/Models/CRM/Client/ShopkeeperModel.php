<?php declare(strict_types=1);

namespace App\Models\CRM\Client;

use App\Domain\CRM\Client\Entity\Shopkeeper;
use Illuminate\Database\Eloquent\Model;

final class ShopkeeperModel extends Model implements Shopkeeper
{
    protected $table = self::TABLE;

    protected $fillable = [
        'id',
        'document'
    ];

    public $timestamps = false;

    public function cnpj(): string
    {
        return $this->document;
    }

    public function client()
    {
        return $this->morphOne(ClientModel::class, 'document');
    }
}
