<?php declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Domain\CRM\Client\Entity\Person;
use App\Domain\CRM\Client\Entity\Shopkeeper;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;
use App\Models\CRM\Client\ClientModel;
use App\Models\CRM\Client\PersonModel;
use App\Models\CRM\Client\ShopkeeperModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Class ClientsController
 * @package App\Http\Controllers\Api
 */
final class ClientsController extends Controller
{
    /**
     * @return AnonymousResourceCollection
     */
    public function index() : AnonymousResourceCollection
    {
        $data = $this->queryBuilder()->limit(2)->get();
        return ClientResource::collection($data);
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function persons(): AnonymousResourceCollection
    {
        $data = $this->queryBuilder()->where('document_type', '=', PersonModel::class)->get();
        return ClientResource::collection($data);
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function shopkeepers(): AnonymousResourceCollection
    {
        $data = $this->queryBuilder()->where('document_type', '=', ShopkeeperModel::class)->get();
        return ClientResource::collection($data);
    }

    protected function queryBuilder(): Builder
    {
        return ClientModel::query();
    }

}
