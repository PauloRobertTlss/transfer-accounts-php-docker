<?php

namespace App\Http\Resources;

use App\Models\CRM\Client\ShopkeeperModel;
use Illuminate\Http\Resources\Json\JsonResource;

final class ClientResource extends JsonResource
{
    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'name' => $this->name,
            'uuid' => $this->id,
            'created_at' => $this->created_at,
            'type' => $this->type(),
            'bank_accounts' => new BankAccountResource($this->bankAccount)
        ];
    }

    private function type(): string
    {

        if ($this->resource->getDocument() instanceof ShopkeeperModel) {
            return 'CNPJ';
        }

        return 'CPF';
    }
}
