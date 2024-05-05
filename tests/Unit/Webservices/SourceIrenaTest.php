<?php

use Illuminate\Support\Facades\Http;

it('check if exchange data api work', function () {
    $token = config('services.sourceIrena.key.1');
    $response = Http::get("service.tsetmc.com/webservice/TsePublicV2.asmx");
});



