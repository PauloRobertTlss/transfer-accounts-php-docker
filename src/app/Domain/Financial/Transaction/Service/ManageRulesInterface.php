<?php declare(strict_types=1);

namespace App\Domain\Financial\Transaction\Service;

use App\Domain\CRM\Client\Entity\ClientInterface;
use App\Services\Transaction\ManageRule\Contract\RuleInterface;

interface ManageRulesInterface
{
    /**
     * @param $rule string|RuleInterface
     * @return $this
     */
    public function pushRule($rule): self;

    /**
     * @param ClientInterface $client
     */
    public function parseRules(ClientInterface $client) :void;

}
