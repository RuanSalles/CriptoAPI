<?php

namespace Database\Seeders;

use App\Models\Coin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class CoinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $coins = [
            [
            'id_name' => 'bitcoin',
            'name' => 'Bitcoin',
            'symbol' => 'btc'
            ],
            [
                'id_name' => 'ethereum',
                'name' => 'Ethereum',
                'symbol' => 'eth'
            ],
            [
                'id_name' => 'dacxi',
                'name' => 'Dacxi',
                'symbol' => 'dacxi'
            ],
            [
                'id_name' => 'pstake-staked-atom',
                'name' => 'pSTAKE Staked ATOM',
                'symbol' => 'stkatom'
            ],
        ];

        foreach ($coins as $coin) {
            Coin::create(
                [
                    'id' => Uuid::uuid4(),
                    'id_name' => $coin['id_name'],
                    'name' => $coin['name'],
                    'symbol' => $coin['symbol']
                ]);
        }

    }
}
