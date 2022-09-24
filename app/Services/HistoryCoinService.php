<?php

namespace App\Services;

use App\Models\Coin;
use App\Models\HistoryCoin;
use App\Repositories\HistoryCoinRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

/**
 *
 */
class HistoryCoinService
{

    /**
     * @var Coin
     */
    protected Coin $coin;

    /**
     * @var HistoryCoin
     */
    protected HistoryCoin $historyCoin;

    /**
     * @var HistoryCoinRepository
     */
    protected HistoryCoinRepository $historyCoinRepository;

    /**
     * @param Coin $coin
     * @param HistoryCoin $historyCoin
     */
    public function __construct(Coin $coin, HistoryCoin $historyCoin, HistoryCoinRepository $historyCoinRepository)
    {
        $this->coin = $coin;
        $this->historyCoin = $historyCoin;
        $this->historyCoinRepository = $historyCoinRepository;
    }

    /**
     * @return \Closure|mixed|null
     */
    public function loadCoin()
    {
        return $this->historyCoin->historyList();
    }

    /**
     * @param $coinId
     * @return string
     */
    public function findSpecificCoin($coinId): mixed
    {
        return $this->coin->findCoinForNameId($coinId);
    }

    /**
     * @return bool
     */
    public function storeAllCoins(): bool
    {
        $coins = [
            'bitcoin',
            'pstake-staked-atom',
            'ethereum',
            'dacxi'
        ];

        foreach ($coins as $coin) {
            $coinId = $this->findSpecificCoin($coin);
            $this->historyCoinRepository->storeSpecificCoin($coin, $coinId);
        }

        return true;
    }

    /**
     * @param array $data
     * @return bool
     */
    public function saveHistoryCoin(array $data): bool
    {
        $coinId = $this->findSpecificCoin($data['id_name']);

        return $this->historyCoinRepository->save($data, $coinId);
    }

    public function allCoins()
    {
        return $this->historyCoinRepository->loadAllCoins();
    }

    public function coin(string $coin): JsonResponse
    {
        $request = json_decode(Http::get("https://api.coingecko.com/api/v3/coins/{$coin}"));

        return response()->json([
            "coin_data" => [
                'id' => $request->id,
                'name' => $request->name,
                'symbol' => $request->symbol
            ],
            "current_price" => $request->market_data->current_price
        ]);
    }


    public function loadCoinForUuid($idName)
    {
        $search = $this->historyCoinRepository->loadCoinUuid($idName);
        return $search[0]['id'];

    }

    public function loadHistoryForDate(string $coin, string $date): JsonResponse
    {
        $search = $this->loadCoinForUuid($coin);

        return response()->json($this->historyCoinRepository->loadCoinHistoryForSpecificDate($this->loadCoinForUuid($coin),$date));
    }
}