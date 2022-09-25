<?php

namespace App\Services;

use App\Models\Coin;
use App\Models\HistoryCoin;
use App\Repositories\HistoryCoinRepository;
use Closure;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

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
     * @return Closure|mixed|null
     */
    public function loadCoin(): mixed
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

    /**
     * @return array
     */
    public function allCoins(): array
    {
        return $this->historyCoinRepository->loadAllCoins();
    }

    /**
     * @param string $coin
     * @return ResponseFactory|Response
     */
    public function coin(string $coin): ResponseFactory|Response
    {
        $request = json_decode(Http::get("https://api.coingecko.com/api/v3/coins/{$coin}"));

        return jsend_success([
            "coin_data" => [
                'id' => $request->id,
                'name' => $request->name,
                'symbol' => $request->symbol
            ],
            "current_price" => $request->market_data->current_price
        ]);
    }


    /**
     * @param $idName
     * @return mixed
     */
    public function loadCoinForUuid($idName): mixed
    {
        $search = $this->historyCoinRepository->loadCoinUuid($idName);
        return $search[0]['id'];
    }

    /**
     * @param string $coin
     * @param string $date
     * @param string|null $time
     * @return array|null
     */
    public function loadHistoryForDate(string $coin, string $date, string $time = null): ?array
    {
        return $this->historyCoinRepository->loadCoinHistoryForSpecificDate($this->loadCoinForUuid($coin), $date, $time);
    }

    /**
     * @param $coin
     * @param $date
     * @return array
     */
    public function loadHistoryToAPI($coin, $date): array
    {
        $dateString = strtotime($date);
        $formatDate = date('d-m-Y', $dateString);
        $request = json_decode(Http::get("https://api.coingecko.com/api/v3/coins/{$coin}/history?date={$formatDate}"));

        return [
            "coin_data" => [
                'id' => $request->id,
                'name' => $request->name,
                'symbol' => $request->symbol
            ],
            "current_price" => $request->market_data->current_price
        ];
    }
}