<?php 
namespace Javck\Ecpay\Facades;

use Illuminate\Support\Facades\Facade;

class EcPay extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ecpay';
    }
}