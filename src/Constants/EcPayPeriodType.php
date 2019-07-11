<?php
namespace Javck\Ecpay\Constants;

/**
 * 定期定額的週期種類。
 */
class EcPayPeriodType
{
    /**
     * 無
     */
    const None = '';
    /**
     * 年
     */
    const Year = 'Y';
    /**
     * 月
     */
    const Month = 'M';
    /**
     * 日
     */
    const Day = 'D';

    /**
     * @return \Illuminate\Support\Collection
     */
    static public function getConstantValues()
    {
        return collect([
            self::None,
            self::Year,
            self::Month,
            self::Day
        ])->unique();
    }
}