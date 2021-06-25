<?php

namespace App\Http\Resources;

use App\Models\CRM\Client\ShopkeeperModel;
use Illuminate\Http\Resources\Json\JsonResource;

final class ClientResource extends JsonResource
{
    /**
     * @return array
     */
    public function toArray($request): array
    {
        return parent::toArray($request);
    }

    private function type(): string
    {

        if ($this->resource->getDocument() instanceof ShopkeeperModel) {
            return 'CNPJ';
        }

        return 'CPF';
    }
}
