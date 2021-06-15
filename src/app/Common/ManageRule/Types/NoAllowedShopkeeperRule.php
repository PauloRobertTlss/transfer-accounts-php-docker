<?php declare(strict_types=1);

namespace App\Common\ManageRule\Types;

use App\Domain\CRM\Client\Entity\ClientInterface;
use App\Domain\CRM\Client\Entity\ShopkeeperInterface;
use App\Common\ManageRule\Contract\RuleInterface;
use App\Common\ManageRule\Exceptions\NoAllowedShopKeeperRuleException;
use Illuminate\Support\Facades\Log;
use Monolog\Logger;

class NoAllowedShopkeeperRule implements RuleInterface
{

    public function parseOrFail(ClientInterface $client): bool
    {
        $personOrShopkeeper = $client->getDocument();

        if (!$personOrShopkeeper instanceof ShopkeeperInterface) {
            return true;
        }

        /** @var ShopkeeperInterface $document */
        Log::error('Transaction not allowed [' . env('APP_NAME') . '] cpnj:' . $personOrShopkeeper->cnpj());
        throw new NoAllowedShopKeeperRuleException('Ops! ShopKeeper [' . env('APP_NAME'). '] no allowed ' . $personOrShopkeeper->cnpj());
    }
}
