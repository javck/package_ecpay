<?php
/**
 * Created by PhpStorm.
 * User: Zack
 * Date: 2019/7/12
 * Time: 上午 1:31
 */

namespace Javck\Ecpay;

class EcPay
{
    public static $useECPayRoute = true;

    public static $sendForm = null;

    public static function ignoreRoutes()
    {
        static::$useECPayRoute = false;
        return new static;
    }


}