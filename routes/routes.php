<?php

Route::prefix('ecpay')->group(function(){
    Route::post('notify', 'App\Http\Controllers\EcPayController@notifyUrl')
        ->name('ecpay.notify');
    Route::post('return', 'App\Http\Controllers\EcPayController@returnUrl')
        ->name('ecpay.return');
});