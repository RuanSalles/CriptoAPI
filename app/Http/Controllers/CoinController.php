<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreCoinRequest;
use App\Models\Coin;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class CoinController extends Controller
{
    /**
     * @var Coin
     */
    protected Coin $coin;

    /**
     * @param Coin $coin
     */
    public function __construct(Coin $coin)
    {
        $this->coin = $coin;
    }


    /**
     * @return ResponseFactory|Response
     */
    public function list(): ResponseFactory|Response
    {
        $result = Coin::all()->map(function ($result) {
            return [
                'id_name' => $result->id_name,
                'name' => $result->name,
                'symbol' => $result->symbol
            ];
        });

        return jsend_success($result);
    }

}
