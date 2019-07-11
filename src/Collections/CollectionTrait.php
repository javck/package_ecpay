<?php
/**
 * Created by PhpStorm.
 * User: Zack
 * Date: 2019/07/12
 * Time: 上午 1:30
 */

namespace Javck\Ecpay\Collections;


trait CollectionTrait
{
    public function getStatus()
    {
        return $this->status;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getItems()
    {
        return $this->items;
    }
}