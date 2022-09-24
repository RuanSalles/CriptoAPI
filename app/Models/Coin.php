<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\HigherOrderBuilderProxy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *
 */
class Coin extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'id_name',
        'symbol',
        'name'
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'id' => 'string'
    ];

    /**
     * @return BelongsTo
     */
    public function history(): BelongsTo
    {
        return $this->belongsTo(HistoryCoin::class);
    }

    /**
     * @param $coinIdName
     * @return HigherOrderBuilderProxy|mixed
     */
    public function findCoinForNameId($coinIdName): mixed
    {
        $consult = Coin::query()
            ->where('id_name', $coinIdName)
            ->latest()
            ->first();

        return $consult->id;
    }
}
