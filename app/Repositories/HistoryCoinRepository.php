<?php

namespace App\Repositories;

use App\Models\Coin;
use App\Models\HistoryCoin;
use Illuminate\Support\Facades\Http;
use Ramsey\Uuid\Uuid;

/**
 *
 */
class HistoryCoinRepository
{
    /**
     * @param array $data
     * @param $coinId
     * @return bool
     */
    public function save(array $data, $coinId): bool
    {
        $history = new HistoryCoin;
        $history->id = Uuid::uuid4();
        $history->coin_id = $coinId;
        $history->current_price = $data['current_price'];
        $history->save();

        return true;
    }

    /**
     * @param $coin
     * @return void
     */
    public function storeSpecificCoin($coin, $coinId): void
    {
        $request = json_decode(Http::get("https://api.coingecko.com/api/v3/coins/{$coin}"));

        $data = [
            'current_price' => $request->market_data->current_price
        ];

        $history = new HistoryCoin;
        $history->id = Uuid::uuid4();
        $history->coin_id = $coinId;
        $history->current_price = json_encode($data['current_price']);
        $history->save();
    }

    /**
     * @return array
     */
    public function loadAllCoins(): array
    {
        $coins = Coin::select('id_name')->get()->toArray();
        $result = [];
        foreach ($coins as $coin) {
            $result[] = $coin['id_name'];
        }

        return $result;
    }

    /**
     * @param string $coin
     * @param $date
     * @param $time
     * @return array|null
     */
    public function loadCoinHistoryForSpecificDate(string $coin, $date, $time = null): ?array
    {
        $start_date = $date . ' 00:00:00';
        $end_date = $date . " 23:59:59";

        if (!empty($time)) {
            $end_date = $date . " $time";
        }


        $history = HistoryCoin::query()
            ->where('coin_id', $coin)
            ->whereBetween('created_at', [$start_date, $end_date])
            ->with('coin')
            ->get()
            ->last();

        if (!empty($history)) {
            return [
                'coin' => [
                    'id' => $history->coin->id_name,
                    'name' => $history->coin->name,
                    'symbol' => $history->coin->symbol
                ],
                'current_price' => json_decode($history->current_price)
            ];
        }

        return null;
    }

    /**
     * @param $nameId
     * @return array
     */
    public function loadCoinUuid($nameId): array
    {
        return Coin::query()
            ->where('id_name', $nameId)
            ->get()
            ->toArray();
    }
}