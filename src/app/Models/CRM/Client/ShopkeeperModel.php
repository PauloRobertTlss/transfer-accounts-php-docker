<?php declare(strict_types=1);

namespace App\Models\CRM\Client;

use App\Domain\CRM\Client\Entity\ShopkeeperInterface;
use Illuminate\Database\Eloquent\Model;


class ShopkeeperModel extends Model implements ShopkeeperInterface
{
    protected string $table = 'shopkeepers';

    protected array $fillable = [
        'id',
        'document'
    ];

    public bool $timestamps = false;

    public function cnpj(): string
    {
        return $this->document;
    }

    public function client()
    {
        return $this->morphOne(ClientModel::class, 'document');
    }
}
