<?php
/**
 * Created by PhpStorm.
 * User: zack
 * Date: 2019/7/12
 * Time: 上午 1:30
 */

namespace Javck\Ecpay;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use javck\Ecpay\Collections\InvoicePostCollection;
use javck\Ecpay\Exceptions\ECPayException;
use javck\Ecpay\Services\StringService;
use javck\Ecpay\Validations\InvoiceValidation;

class Invoice
{
    use ECPayTrait;

    protected $apiUrl;
    protected $postData;
    protected $merchantId;
    protected $hashKey;
    protected $hashIv;
    protected $encryptType='md5';

    protected $checkMacValueIgnoreFields;

    public function __construct(InvoicePostCollection $postData)
    {
        if (config('app.env') == 'production') {
            $this->apiUrl = 'https://einvoice.ecpay.com.tw/Invoice/Issue';
        } else {
            $this->apiUrl = 'https://einvoice-stage.ecpay.com.tw/Invoice/Issue';
        }
        $this->postData = $postData;

        $this->hashKey = config('ecpay.InvoiceHashKey');
        $this->hashIv = config('ecpay.InvoiceHashIV');
        $this->checkMacValueIgnoreFields = [
            'InvoiceRemark', 'ItemName', 'ItemWord', 'ItemRemark', 'CheckMacValue'
        ];
    }

    /**
     * @param $invData
     * @return $this
     * @throws Exceptions\ECPayException
     */
    public function setPostData($invData)
    {
        $this->postData->setData($invData)->setBasicInfo()->setPostData();
        return $this;
    }
}