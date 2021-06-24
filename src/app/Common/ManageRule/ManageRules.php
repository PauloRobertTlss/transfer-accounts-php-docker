<?php declare(strict_types=1);

namespace App\Common\ManageRule;

use App\Common\ManageRule\Contract\RuleInterface;
use App\Common\ManageRule\Exceptions\NoClassRule;
use App\Domain\CRM\Client\Entity\ClientInterface;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

/**
 * Class ManageRules
 * @package App\Common\ManageRule
 */
final class ManageRules implements ManageRulesInterface
{
    private array $rules;

    public function __construct()
    {
        $this->resetRules();
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
     * @throws NoClassRule
     */
    public function pushRule($rule): self
    {
        if (is_string($rule)) {
            $rule = new $rule();
        }

        if (!is_object($rule)) {
            throw new InvalidArgumentException('input argument invalid');
        }

        if (!$rule instanceof RuleInterface) {
            Log::error('Error: ' . env('APP_NAME') . ' danger' . get_class($rule) . ' not is rule', []);
            throw new NoClassRule('Ops!' . get_class($rule) . ' not is rule');
        }

        $this->rules[] = $rule;

        return $this;

    }

}
