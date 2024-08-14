<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use phpDocumentor\Reflection\Types\This;

class stock extends Model
{
    use HasFactory;

    public static array $market = ['بورس', 'فرابورس', 'بورس کالا', 'بورس انرژی'];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'watch_list');
    }

    public static function getStocks($request){
        logger("get stock");
        return self::query()
            ->where('symbol', 'like', "%$request->stock%")
            ->orWhere('company', 'like', "%$request->stock%")
            ->take(10)
            ->get();
    }
}
