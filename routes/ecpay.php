<?php

Route::prefix('ecpay')->group(function(){
    Route::post('notify', 'App\Http\Controllers\EcPayController@notifyUrl')
        ->name('ecpay.notify');
    Route::post('return', 'App\Http\Controllers\EcPayController@returnUrl')
        ->name('ecpay.return');
});

Route::group(['middleware' => ['javck.checkForMaintenanceMode','web'],'prefix' => 'ecpay','namespace' => '\App\Http\Controllers'], function () {
    Route::get('createOrder/{id}','SiteController@createPaymentOrderPage');
    Route::get('request','SiteController@paymentRequest')->name('payment.request');
    Route::post('submitCheckout','SiteController@createPaymentOrder');
    Route::post('done/{order_id}','SiteController@paymentReturn');
});