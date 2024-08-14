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
            'stocks' => Inertia::lazy(fn() => $request->stock ? stock::getStocks($request) : null),
            'watchList' => fn() => $request->user()->watchLists,
        ]);

    }
}
