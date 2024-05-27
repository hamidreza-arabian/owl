<?php

test('user can watch stock', function () {
    $user = \App\Models\User::factory()->create();
    $stocks = Stock::factory()->create();
    $user->stock->watch();
});
