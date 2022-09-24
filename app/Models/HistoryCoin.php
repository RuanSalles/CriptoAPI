<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 *
 */
class HistoryCoin extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'coin_id',
        'current_price'
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'current_price' => 'array'
    ];

    /**
     * @return HasOne
     */
    public function coin(): HasOne
    {
        return $this->hasOne(Coin::class, 'id', 'coin_id');
    }

    /**
     * @return \Closure|mixed|null
     */
    public function historyList(): mixed
    {
        return $this->with('coin')
            ->get()
            ->last();
    }

}
