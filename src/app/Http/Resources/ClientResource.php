<?php

namespace App\Http\Resources;

use App\Domain\CRM\Client\Entity\ClientInterface;
use App\Models\CRM\Client\ShopkeeperModel;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'uuid' => $this->id,
            'created_at' => $this->created_at,
            'type' => $this->type(),
            'bank_accounts' => new BankAccountResource($this->bankAccount)
        ];
    }

    private function type()
    {
        /** @var ClientInterface $client */
        $client = $this->resource;

        if ($client->getDocument() instanceof ShopkeeperModel) {
            return 'CNPJ';
        }

        return 'CPF';
    }
}
