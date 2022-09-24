<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreCoinRequest;
use App\Models\Coin;
use Illuminate\Http\JsonResponse;

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        $result = Coin::all()->map(function ($result) {
            return [
                'id_name' => $result->id_name,
                'name' => $result->name,
                'symbol' => $result->symbol
            ];
        });

        return response()->json($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCoinRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCoinRequest $request)
    {
        //
    }

}
