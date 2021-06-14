<?php declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Domain\Financial\Transaction\Service\TransactionServiceAsyncInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Transaction\TransactionRequest;
use Illuminate\Support\Facades\Log;

class TransactionsController extends Controller
{
    /**
     * @var TransactionServiceAsyncInterface
     */
    private TransactionServiceAsyncInterface $transactionService;

    /**
     * TransactionsControllers constructor.
     * @param TransactionServiceAsyncInterface $transactionService
     */
    public function __construct(TransactionServiceAsyncInterface $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    /**
     * @param TransactionRequest $request
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function create(TransactionRequest $request)
    {
        try {

            Log::info('Started created transaction ' .env('APP_NAME'), ['context' => $request->all()]);
            return response()->json($this->transactionService->store($request), 200);

        }catch (\Exception $exception) {
            Log::error('Error transaction ' .env('APP_NAME'),['context' => debug_backtrace(3)]);
            return response()->json(['error' => 'Ops! transaction unprocessable'], 422);
        }

    }

}
