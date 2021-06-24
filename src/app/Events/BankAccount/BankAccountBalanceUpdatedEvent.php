<?php

namespace App\Events\BankAccount;

use App\Models\Financial\BankAccount\BankAccountModel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;

final class BankAccountBalanceUpdatedEvent
{

    use InteractsWithSockets, SerializesModels;
    public $bankAccount; //eventos broadcast - O Laravel serializa apenas variaveis publicas

    public function __construct(BankAccountModel $bankAccount)
    {
        $this->bankAccount = $bankAccount;
    }

    public function broadcastAs() {
        return 'transfer.events.update_balance_account';
    }

}
