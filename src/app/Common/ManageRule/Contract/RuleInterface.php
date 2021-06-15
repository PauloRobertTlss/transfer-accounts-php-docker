<?php declare(strict_types=1);

namespace App\Common\ManageRule\Contract;

use App\Domain\CRM\Client\Entity\ClientInterface;

interface RuleInterface
{
    /**
     * @param ClientInterface $client
     * @return bool
     */
    public function parseOrFail(ClientInterface $client): bool;
}
