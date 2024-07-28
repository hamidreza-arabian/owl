<?php

namespace App\Http\Controllers;

use App\Models\stock;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WatchListController extends Controller
{
    public function index(Request $request)
    {

        return Inertia::render('WatchList/Index', [
            'stocks' => $request->stock ?
                stock::query()
                    ->where('symbol', 'like', "%$request->stock%")
                    ->orWhere('company', 'like', "%$request->stock%")
                    ->take(30)
                    ->get() : null,
            'watchList' => $request->user()->watchLists,
        ]);

    }
}
