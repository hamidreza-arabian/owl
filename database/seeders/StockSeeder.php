<?php

namespace Database\Seeders;

use App\Models\stock;
use Illuminate\Database\Seeder;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        stock::factory([
            'symbol' => 'شبریز',
            'company' => 'پالایش نفت تبریز',
        ])->create();
        stock::factory([
            'symbol' => 'شنفت',
            'company' => 'نفت‌ پارس‌',
        ])->create();
        stock::factory([
            'symbol' => 'شتران',
            'company' => 'پالایش نفت تهران',
        ])->create();
        stock::factory([
            'symbol' => 'شپنا',
            'company' => 'پالایش نفت اصفهان',
        ])->create();
    }
}
