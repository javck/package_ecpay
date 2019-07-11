<?php
namespace Javck\Ecpay;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Javck\Ecpay\Collections\CheckoutPostCollection;
use Javck\Ecpay\Collections\InvoicePostCollection;
use Javck\Ecpay\Exceptions\ECPayException;
use Javck\Ecpay\Services\StringService;
use Javck\Ecpay\Validations\InstallmentValidation;
use Javck\Ecpay\Validations\InvoiceValidation;
use Javck\Ecpay\Validations\ItemValidation;
use Javck\Ecpay\Validations\PaymentValidation;
use Javck\Ecpay\Validations\PeriodAmountValidator;

class Checkout
{
    use EcPayTrait;

    protected $apiUrl;
    protected $postData;
    protected $platform;
    protected $merchantId;
    protected $hashKey;
    protected $hashIv;
    protected $encryptType='sha256';
    protected $notifyUrl;

    protected $itemValidation;

    public function __construct(CheckoutPostCollection $checkoutPostCollection)
    {
        if (config('app.env') == 'production') {
            $this->apiUrl = 'https://payment.ecpay.com.tw/Cashier/AioCheckOut/V5';
        } else {
            $this->apiUrl = 'https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V5';
        }
        $this->postData = $checkoutPostCollection;

        $this->merchantId = config('ecpay.MerchantId');
        $this->hashKey = config('ecpay.HashKey');
        $this->hashIv = config('ecpay.HashIV');
    }

    /**
     * Handle the Post Data
     * @param $data
     * @return $this
     * @throws ECPayException
     */
    public function setPostData($data)
    {
        $validator = PaymentValidation::postDataValidator($data);
        if ($validator->fails()) {
            throw new ECPayException($validator->getMessageBag());
        }
        $this->postData->setData($data)->setBasicInfo()->setOrderInfo()->setOptionalInfo()->optimize();
        return $this;
    }

    /**
     * 還沒用到
     * @param string $platformId
     * @return $this
     * @throws ECPayException
     */
    public function setPlatform($platformId)
    {
        if (strlen($platformId) > 10) {
            throw new ECPayException('PlatformId max length is 10');
        }
        $this->platform = $platformId;
        $this->postData->put('PlatformId', $platformId);
        return $this;
    }

    /**
     * @param string $installmentData
     * @return $this;
     * @throws ECPayException
     */
    public function withInstallment($installmentData)
    {
        $this->postData->setInstallment($installmentData);
        return $this;
    }

    /**
     * @param $data
     * @return $this
     * @throws ECPayException
     */
    public function withPeriodAmount($data)
    {
        $this->postData->setPeriodAmount($data);
        return $this;
    }
    /**
     * 當要開立發票時，帶入此方法
     * @param array $invData
     * @return $this
     * @throws ECPayException
     */
    public function withInvoice($invData)
    {
        $invPostData = new InvoicePostCollection;
        $invPostData->setData($invData)->setPostDataForCheckout();
        $this->postData = collect(array_merge($this->postData->toArray(), $invPostData->toArray()));
        return $this;
    }

    public function setNotifyUrl($url)
    {
        $this->postData->notifyUrl = $url;
        return $this;
    }

    public function setReturnUrl($url)
    {
        $this->postData->returnUrl = $url;
        return $this;
    }
}