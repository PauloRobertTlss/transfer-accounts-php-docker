<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

final class BankAccountResource extends JsonResource
{
    public function toArray()
    {
        return [
            'balance' => $this->balance,
            'account' => $this->account,
            'agency' => $this->agency
        ];
    }
}
