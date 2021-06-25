<?php declare(strict_types=1);

namespace App\Services\Transaction\Policies;

use App\Common\ManageRule\ManageRulesInterface;
use App\Common\ManageRule\Types\BalanceNoZeroRule;
use App\Common\ManageRule\Types\NewResolverRule;
use App\Common\VerifyAuthorization\VerifyAuthorizationInterface;
use App\Domain\Financial\Transaction\Request\TransactionRequest;
use App\Models\CRM\Client\ClientModel;

/**
 * Class BalanceRuleAndGrantPolicies
 * @package App\Services\Transaction\Policies
 */
final class BalanceRuleAndGrantPolicies implements TransactionPolicies
{
    /**
     * @var VerifyAuthorizationInterface
     */
    private VerifyAuthorizationInterface $authorization;
    /**
     * @var ManageRulesInterface
     */
    private ManageRulesInterface $manageRules;

    /**
     * Policies constructor.
     * @param VerifyAuthorizationInterface $authorization
     * @param ManageRulesInterface $manageRules
     */
    public function __construct(VerifyAuthorizationInterface $authorization, ManageRulesInterface $manageRules)
    {
        $this->authorization = $authorization;
        $this->manageRules = $manageRules;
    }

    /**
     * @param TransactionRequest $request
     * @throws \Exception
     */
    public function assertPolicies(TransactionRequest $request): void
    {
        $payload = [
            'payer' => $request->payer(),
            'payee' => $request->payee(),
            'value' => $request->value(),
        ];

        $this->assertRules($payload);
        $this->authorization->grantAuthorization($payload);
    }

    /**
     * @param array $payload
     * @throws \Exception
     */
    private function assertRules(array $payload): void
    {
        $clientPayer = ClientModel::with('bankAccount')->find($payload['payer']);
        $this->manageRules
            ->pushRule(new BalanceNoZeroRule($payload['value']))
            ->pushRule(new NewResolverRule($payload['value']))
            ->parseRules($clientPayer);

    }
}
