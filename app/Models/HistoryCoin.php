<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class HistoryCoin extends Model
{
    use HasFactory;

    protected $fillable = [
        'coin_id',
        'current_price'
    ];

    protected $casts = [
        'current_price' => 'array'
    ];

    public function coin(): HasOne
    {
        return $this->hasOne(Coin::class, 'id', 'coin_id');
    }

    public function historyList()
    {
        return $this->with('coin')
            ->get()
            ->last();
    }

}
