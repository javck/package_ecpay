<?php
/**
 * Created by PhpStorm.
 * User: Zack
 * Date: 2019/07/12
 * Time: 上午 1:35
 */

namespace Javck\Ecpay\Collections;


use Illuminate\Support\Collection;
use Javck\Ecpay\Exceptions\ECPayException;

class InvoiceResponseCollection extends Collection
{
    use CollectionTrait;

    protected $status;
    protected $message;

    /**
     * @param $response
     * @return $this
     * @throws ECPayException
     */
    public function collectResponse($response)
    {
        if (!isset($response['RtnCode'])) {
            throw new ECPayException('Error Response type');
        }
        $this->status = $response['RtnCode'];
        $this->message = $response['RtnMsg'];
        $allParams = collect(self::invoiceInfo())->unique();
        $allParams->each(function($param) use($response) {
            if (isset($response[$param])) {
                $this->put($param, $response[$param]);
            }
        });
        return $this;
    }

    static public function invoiceInfo()
    {
        return [
            'InvoiceNumber', 'InvoiceDate', 'RandomNumber', 'CheckMacValue'
        ];
    }
}