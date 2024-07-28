<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class stock extends Model
{
    use HasFactory;

    public static array $market = ['بورس', 'فرابورس', 'بورس کالا', 'بورس انرژی'];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'watch_list');
    }
}
