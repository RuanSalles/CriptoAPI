<?php

namespace App\Repositories;

use App\Models\Coin;
use App\Models\HistoryCoin;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;
use Ramsey\Uuid\Uuid;

class HistoryCoinRepository
{
    public function save(array $data, $coinId)
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
    public function storeSpecificCoin($coin, $coinId)
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

    public function loadAllCoins()
    {
        $coins = Coin::select('id_name')->get()->toArray();
        $result = [];
        foreach ($coins as $coin) {
            $result[] = $coin['id_name'];
        }

        return $result;
    }

    public function loadCoinHistoryForSpecificDate(string $coin, $date)
    {
        $start_date = $date . ' 00:00:00';
        $end_date = $date .  ' 23:59:59';
        $history = HistoryCoin::query()
            ->where('coin_id', $coin)
            ->whereBetween('created_at', [$start_date, $end_date])
            ->with('coin')
            ->get()
            ->last();


        return [
            'coin' => [
            'id' => $history->coin->id_name,
            'name' => $history->coin->name,
            'symbol' => $history->coin->symbol
            ],
            'current_price' => json_decode($history->current_price)
        ];
    }

    public function loadCoinUuid($nameId)
    {

        return Coin::query()
            ->where('id_name',$nameId)
            ->get()
            ->toArray();
    }
}