<?php

namespace App\Providers\Transaction;

use App\Common\ManageRule\ManageRules;
use App\Common\ManageRule\ManageRulesInterface;
use App\Common\VerifyAuthorization\{VerifyAuthorization,VerifyAuthorizationInterface};
use App\Domain\Financial\BankAccount\Repository\BankAccountRepository;
use App\Domain\Financial\Transaction\Repository\{
    TransactionPayeeRepository,
    TransactionPayerRepository
};
use App\Domain\Financial\Transaction\Service\{
    TransactionServiceAsync,
};
use App\ExternalAuthorization\Build\Singleton;
use App\ExternalAuthorization\ExternalAuthorization;
use App\Repositories\BankAccount\BankAccountRepositoryEloquent;
use App\Repositories\Transactions\{TransactionPayeeRepositoryEloquent, TransactionPayerRepositoryEloquent};
use App\Services\Transaction\{
    Policies\BalanceRuleAndGrantPolicies,
    Policies\TransactionPolicies,
    TransactionServiceAsync as BaseTransactionServiceAsync};
use Illuminate\Support\ServiceProvider;

final class TransactionServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(BankAccountRepository::class, BankAccountRepositoryEloquent::class);
        $this->app->bind(TransactionPayerRepository::class, TransactionPayerRepositoryEloquent::class);
        $this->app->bind(TransactionPayeeRepository::class, TransactionPayeeRepositoryEloquent::class);

        $this->app->bind(ManageRulesInterface::class, ManageRules::class);
        $this->app->bind(TransactionServiceAsync::class, BaseTransactionServiceAsync::class);
        $this->app->bind(VerifyAuthorizationInterface::class, VerifyAuthorization::class);
        $this->app->bind(TransactionPolicies::class, BalanceRuleAndGrantPolicies::class);
        $this->app->singleton(ExternalAuthorization::class, function () {
                return Singleton::instance();
        });
    }

}
