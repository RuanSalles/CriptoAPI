<?php

namespace App\Http\Controllers;

use App\Services\HistoryCoinService;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class HistoryCoinController extends Controller
{
    /**
     * @var HistoryCoinService
     */
    protected HistoryCoinService $historyCoinService;

    /**
     * @param HistoryCoinService $historyCoinService
     */
    public function __construct(HistoryCoinService $historyCoinService)
    {
        $this->historyCoinService = $historyCoinService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response|ResponseFactory
     */
    public function index(): ResponseFactory|Response
    {
        $payload = $this->historyCoinService->loadCoin();

        return jsend_success([
            'coin' => [
                'id' => $payload->coin->id_name,
                'name' => $payload->coin->name,
                'symbol' => $payload->coin->symbol
            ],
            'current_price' => json_decode($payload->current_price)
        ]);
    }

    /**
     */
    public function findSpecificCoin($coinId): Response|ResponseFactory
    {
        $values = array_values($this->historyCoinService->allCoins());

        if (!in_array($coinId, $values)) {
            return jsend_error('invalid value', 400);
        }

        return $this->historyCoinService->coin($coinId);
    }

    /**
     * @param string $coin
     * @param Request $request
     * @return Response|ResponseFactory
     */
    public function loadHistoryForDate(string $coin, Request $request): ResponseFactory|Response
    {
        $date = $request->date;
        $time = $request->time;

        $values = array_values($this->historyCoinService->allCoins());

        if (!in_array($coin, $values)) {
            return jsend_error('invalid value', 400);
        }

        $historyDataBase = $this->historyCoinService->loadHistoryForDate($coin, $date, $time);

        if (empty($historyDataBase)) {
            return jsend_success($this->historyCoinService->loadHistoryToAPI($coin, $date));
        }

        return jsend_success($historyDataBase);
    }


}
