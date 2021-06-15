<?php declare(strict_types=1);

namespace App\Common\ManageRule;

use App\Domain\CRM\Client\Entity\ClientInterface;
use App\Common\ManageRule\Contract\RuleInterface;

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
