<?php declare(strict_types=1);

namespace App\Models\CRM\Client;

use App\Domain\CRM\Client\Entity\Person;
use Illuminate\Database\Eloquent\Model;

final class PersonModel extends Model implements Person
{
    protected $table = self::TABLE;

    protected $fillable = [
        'id',
        'document'
    ];

    public $timestamps = false;

    public function cpf(): string
    {
        return $this->document;
    }

    public function client()
    {
        return $this->morphOne(ClientModel::class, 'document');
    }

}
