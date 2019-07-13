<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Javck\Ecpay\Collections\CheckoutResponseCollection;
use Javck\Ecpay\Services\StringService;

class EcPayController extends Controller
{
    protected $checkoutResponse;
    public function __construct(CheckoutResponseCollection $checkoutResponse)
    {
        $this->checkoutResponse = $checkoutResponse;
    }

    //當付款完成，EcPay會回呼這個網址
    public function notifyUrl(Request $request)
    {
        $serverPost = $request->post();
        $checkMacValue = $request->post('CheckMacValue');
        unset($serverPost['CheckMacValue']);
        $checkCode = StringService::checkMacValueGenerator($serverPost);
        if ($checkMacValue == $checkCode) {
            return '1|OK';
        } else {
            return '0|FAIL';
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \TsaiYiHua\ECPay\Exceptions\ECPayException
     */
    //預設付款完之後，前台轉址函式
    public function returnUrl(Request $request)
    {
        $serverPost = $request->post();
        $checkMacValue = $request->post('CheckMacValue');
        unset($serverPost['CheckMacValue']);
        $checkCode = StringService::checkMacValueGenerator($serverPost);
        if ($checkMacValue == $checkCode) {
            if (!empty($request->input('redirect'))) {
                return redirect($request->input('redirect'));
            } else {
                dd($this->checkoutResponse->collectResponse($serverPost));
            }
        }
    }
}