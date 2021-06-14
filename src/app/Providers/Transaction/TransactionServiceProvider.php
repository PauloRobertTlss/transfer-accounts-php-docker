<?php

namespace App\Providers\Transaction;

use App\Domain\Financial\BankAccount\Repository\BankAccountRepositoryInterface;
use App\ExternalAuthorization\Build\Singleton;
use App\ExternalAuthorization\ExternalAuthorizationInterface;
use App\Domain\Financial\Transaction\Repository\{
    TransactionPayeeRepositoryInterface,
    TransactionPayerRepositoryInterface
};
use App\Domain\Financial\Transaction\Service\{
    ManageRulesInterface,
    TransactionServiceAsyncInterface,
    VerifyAuthorizationInterface
};
use App\Repositories\BankAccount\BankAccountRepositoryEloquent;
use App\Repositories\Transactions\{TransactionPayeeRepositoryEloquent, TransactionPayerRepositoryEloquent};
use App\Services\Transaction\{ManageRule\ManageRules, TransactionServiceAsync};
use App\Services\Transaction\VerifyAuthorization\VerifyAuthorization;
use Illuminate\Support\ServiceProvider;

class TransactionServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(BankAccountRepositoryInterface::class, BankAccountRepositoryEloquent::class);
        $this->app->bind(TransactionPayerRepositoryInterface::class, TransactionPayerRepositoryEloquent::class);
        $this->app->bind(TransactionPayeeRepositoryInterface::class, TransactionPayeeRepositoryEloquent::class);

        $this->app->bind(ManageRulesInterface::class, ManageRules::class);
        $this->app->bind(TransactionServiceAsyncInterface::class, TransactionServiceAsync::class);
        $this->app->bind(VerifyAuthorizationInterface::class, VerifyAuthorization::class);
        $this->app->singleton(ExternalAuthorizationInterface::class, Singleton::instance());
    }

}
