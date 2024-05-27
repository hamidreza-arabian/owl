<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class StockWatchController extends Controller
{
    public function index(Request $request)
    {
        $stocks = null;
        if (isset($request->search) and $request->search) {
        }

        return Inertia::render('StockWatch/Index', [
            'stocks' => $stocks,
            'watchStocks' => null,
        ]);
    }
}
