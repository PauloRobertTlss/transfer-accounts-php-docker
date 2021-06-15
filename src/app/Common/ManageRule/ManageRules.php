<?php declare(strict_types=1);

namespace App\Common\ManageRule;

use App\Domain\CRM\Client\Entity\ClientInterface;
use App\Domain\Financial\Transaction\Service\ManageRulesInterface;
use App\Common\ManageRule\Contract\RuleInterface;
use App\Common\ManageRule\Exceptions\NoClassRuleException;
use Illuminate\Support\Facades\Log;

/**
 * Class ManageRules
 * @package App\Common\ManageRule
 */
class ManageRules implements ManageRulesInterface
{
    private array $rules;

    public function __construct()
    {
        $this->resetRules();
        $this->boot();
    }

    public function boot()
    {
    }

    public function parseRules(ClientInterface $client): void
    {
        /** @var RuleInterface $parse */
        foreach ($this->rules as $parse) {
            $parse->parseOrFail($client);
        }

    }

    public function resetRules(): void
    {
        $this->rules = [];
    }

    /**
     * @param RuleInterface|string $rule
     * @return $this
     * @throws NoClassRuleException
     */
    public function pushRule($rule): self
    {
        if (is_string($rule)) {
            $rule = new $rule;
        }

        if (!$rule instanceof RuleInterface) {
            Log::error('Error: ' . env('APP_NAME') . ' danger' . get_class($rule) . ' not is rule', debug_backtrace(3));
            throw new NoClassRuleException('Ops!' . get_class($rule) . ' not is rule');
        }

        $this->rules[] = $rule;

        return $this;

    }

}
