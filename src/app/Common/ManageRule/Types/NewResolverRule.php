<?php declare(strict_types=1);

namespace App\Common\ManageRule\Types;

use App\Common\ManageRule\Contract\RuleInterface;
use App\Common\ManageRule\Exceptions\NoAllowedShopKeeperRule as Exception;
use App\Domain\CRM\Client\Entity\{ClientInterface,Shopkeeper};
use Illuminate\Support\Facades\Log;

final class  NewResolverRule implements RuleInterface
{

    public function parseOrFail(ClientInterface $client): bool
    {
        $personOrShopkeeper = $client->getDocument();

        if (!$personOrShopkeeper instanceof Shopkeeper) {
            return true;
        }

        Log::error('Transaction not allowed [' . env('APP_NAME') . '] cpnj:' . $personOrShopkeeper->cnpj());
        throw new Exception('Ops! ShopKeeper [' . env('APP_NAME'). '] no allowed ' . $personOrShopkeeper->cnpj());
    }
}
