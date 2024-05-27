<?php
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function (){
    $this->user =\App\Models\User::factory()->create();
});
test('watch stock page can be render', function () {
    $response = $this
        ->actingAs($this->user)
        ->get('/سهام-های-تحت-نظر');
    $response->assertOk();

});

test('if user has no stock to watch, stocks should be null', function () {
    $response = $this
        ->actingAs($this->user)
        ->get('/سهام-های-تحت-نظر');
    $response->assertInertia(fn (Assert $page) => $page
        ->component('StockWatch/Index')
        ->has('stocks', null)
    );
});
test('if user has stock to watch, stocks should not be null', function () {
    $response = $this
        ->actingAs($this->user)
        ->get('/سهام-های-تحت-نظر');
    $response->assertInertia(fn (Assert $page) => $page
        ->component('StockWatch/Index')
        ->has('stocks',)
    );
});
