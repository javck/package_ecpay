<?php
namespace Javck\Ecpay\Constants;

/**
 * 付款時操作的載具
 */
class EcPayDeviceType
{
    /**
     * 桌機版付費頁面。
     */
    const PC = 'P';
    /**
     * 行動裝置版付費頁面。
     */
    const Mobile = 'M';

    /**
     * @return \Illuminate\Support\Collection
     */
    static public function getConstantValues()
    {
        return collect([
            self::PC,
            self::Mobile
        ])->unique();
    }
}