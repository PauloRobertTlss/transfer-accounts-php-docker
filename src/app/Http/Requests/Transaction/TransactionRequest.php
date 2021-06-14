<?php declare(strict_types=1);

namespace App\Http\Requests\Transaction;

use App\Domain\Financial\Transaction\Request\TransactionRequestInterface;
use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest implements TransactionRequestInterface
{

    public const RULE_CLIENT_EXIST = 'required|exists:clients,id,deleted_at,NULL';

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'value' => 'numeric|min:1',
            'payee' => self::RULE_CLIENT_EXIST,
            'payer' => self::RULE_CLIENT_EXIST,
        ];
    }

    public function value(): float
    {
        return (float)$this->get('value');
    }

    public function payee(): string
    {
        return $this->get('payee');
    }

    public function payer(): string
    {
        return $this->get('payer');
    }
}
