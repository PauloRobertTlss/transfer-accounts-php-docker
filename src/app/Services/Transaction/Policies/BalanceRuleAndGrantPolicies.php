<?php declare(strict_types=1);

namespace App\Services\Transaction\Policies;

use App\Domain\CRM\Client\Entity\ClientInterface;
use App\Domain\Financial\Transaction\Request\TransactionRequestInterface;
use App\Domain\Financial\Transaction\Service\ManageRulesInterface;
use App\Domain\Financial\Transaction\Service\VerifyAuthorizationInterface;
use App\Models\CRM\Client\ClientModel;
use App\Common\ManageRule\Types\BalanceNoZeroRule;

/**
 * Class BalanceRuleAndGrantPolicies
 * @package App\Services\Transaction
 */
class BalanceRuleAndGrantPolicies implements TransactionPoliciesInterface
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

    public function assertPolicies(TransactionRequestInterface $request): void
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
    private function assertRules(array $payload)
    {
        /** @var ClientInterface $clientPayee */
        $clientPayer = ClientModel::with('bankAccount')->find($payload['payer']);

        $this->manageRules
            ->pushRule(new BalanceNoZeroRule($payload['value']))
            ->parseRules($clientPayer);

    }
}
