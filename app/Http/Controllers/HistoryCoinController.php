<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHistoryCoinRequest;
use App\Models\HistoryCoin;
use App\Services\HistoryCoinService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $payload = $this->historyCoinService->loadCoin();

        return response()->json([
            'coin' => [
                'id' => $payload->coin->id_name,
                'name' => $payload->coin->name,
                'symbol' => $payload->coin->symbol
            ],
            'current_price' => json_decode($payload->current_price)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreHistoryCoinRequest $request
     * @return bool
     */
    public function store(StoreHistoryCoinRequest $request): bool
    {
    }

    /**
     */
    public function findSpecificCoin($coinId)
    {
        $values = array_values($this->historyCoinService->allCoins());

        if (!in_array($coinId, $values)) {
            return response()->json('invalid value', 400);
        }

        return $this->historyCoinService->coin($coinId);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\HistoryCoin $historyCoin
     * @return \Illuminate\Http\Response
     */
    public function show(HistoryCoin $historyCoin)
    {
        //
    }

    public function loadHistoryForDate(string $coin, Request $request): JsonResponse
    {
        $date = $request->date;
        return $this->historyCoinService->loadHistoryForDate($coin, $date);
    }


}
