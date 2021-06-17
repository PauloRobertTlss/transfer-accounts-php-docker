<?php declare(strict_types=1);

namespace App\Common\ManageRule\Types;

use App\Domain\CRM\Client\Entity\ClientInterface;
use App\Common\ManageRule\Contract\RuleInterface;
use App\Common\ManageRule\Exceptions\WithoutBalanceRuleException;

class BalanceNoZeroRule implements RuleInterface
{
    private float $value;

    /**
     * BalanceNoZeroRule constructor.
     * @param float $value
     */
    public function __construct(float $value)
    {
        $this->value = $value;
    }

    public function parseOrFail(ClientInterface $client): bool
    {
        $account = $client->getBankAccount();
        $result = $account->getBalance() - $this->value;

        if ($result > 0) {
            return true;
        }

        throw new WithoutBalanceRuleException('Ops! Without balance [' . env('APP_NAME'). '] bank account ' . $account->id());
    }
}
