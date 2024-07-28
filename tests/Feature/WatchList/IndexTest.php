<?php

use App\Models\stock;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    $this->user = User::factory()->create();
});

test('watch stock page can be render', function () {
    $response = $this
        ->actingAs($this->user)
        ->get('/سهام-های-تحت-نظر');
    $response->assertOk();

});

test('if user has no stock to watch, watchList should be empty ', function () {
    $response = $this
        ->actingAs($this->user)
        ->get('/سهام-های-تحت-نظر');
    $response->assertInertia(fn (Assert $page) => $page
        ->component('WatchList/Index')
        ->has('watchList', 0)
    );
});

test('if user has stock to watch, watchList should not be null', function () {
    $stock = Stock::factory()->create();
    $this->user->addWatchList($stock, ['price' => 1200, 'title' => 'حد ضرر']);
    $response = $this
        ->actingAs($this->user)
        ->get('/سهام-های-تحت-نظر');
    $response->assertInertia(fn (Assert $page) => $page
        ->component('WatchList/Index')
        ->has('watchList', 1)
    );
});

test('user can search for new stock to add to watchlist', function () {
    stock::factory(5)->startWith('توریل')->create();
    $response = $this
        ->actingAs($this->user)
        ->get('/سهام-های-تحت-نظر?stock=توریل');
    $response->assertInertia(fn (Assert $page) => $page
        ->component('WatchList/Index')
        ->has('stocks', 5)
    );
});
