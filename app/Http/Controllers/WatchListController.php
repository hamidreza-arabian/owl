<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class StockWatchController extends Controller
{
    public function index(Request $request)
    {

        return Inertia::render('WatchList/Index', [
            'stock' => null,
            'watchList' => $request->user()->watchLists,
        ]);

    }
}
