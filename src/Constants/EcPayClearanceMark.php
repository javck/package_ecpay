<?php
namespace Javck\Ecpay\Constants;


class EcPayClearanceMark
{
    // 經海關出口
    const Yes = '1';

    // 非經海關出口
    const No = '2';

    /**
     * @return \Illuminate\Support\Collection
     */
    static public function getConstantValues()
    {
        return collect([
            self::No,
            self::Yes
        ])->unique();
    }
}