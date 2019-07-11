<?php
namespace Javck\Ecpay\Validations;

use Illuminate\Support\Facades\Validator;
use Javck\Ecpay\Constants\ECPayCarruerType;
use Javck\Ecpay\Constants\ECPayClearanceMark;
use Javck\Ecpay\Constants\ECPayDonation;
use Javck\Ecpay\Constants\ECPayInvType;
use Javck\Ecpay\Constants\ECPayPrintMark;
use Javck\Ecpay\Constants\ECPayTaxType;

class InvoiceValidation
{
    /**
     * Validation for invoice post data
     * @param $data
     * @return \Illuminate\Contracts\Validation\Validator|\Illuminate\Validation\Validator
     */
    static public function invoiceValidator($data)
    {
        /**
         * items[] = [
         *      'name' => 'abc',
         *      'qty' => 2,
         *      'unit' => 'piece',
         *      'price' => 50
         * ];
         */
        $validator = Validator::make($data, [
            'Items' => 'required|array',
            'OrderId' => 'alpha_num|max:30',
            'CustomerID' => 'alpha_dash|max:20',
            'CustomerIdentifier' => 'int|max:8',
            'CustomerName' => 'required_if:Print,1|max:60',
            'CustomerAddr' => 'required_if:Print,1|max:200',
            'CustomerPhone' => 'required_if:CustomerEmail,null|max:20',
            'CustomerEmail' => 'required_if:CustomerPhone,null|max:200',
            'ClearanceMark' => 'in:'.implode(',', ECPayClearanceMark::getConstantValues()->toArray()),
            'TaxType' => 'in:'.implode(',', ECPayTaxType::getConstantValues()->toArray()),
            'CarruerType' => 'in:'.implode(',', ECPayCarruerType::getConstantValues()->toArray()),
            'CarruerNum' => 'max:64',
            'Donation' => 'in:'.implode(',', ECPayDonation::getConstantValues()->toArray()),
            'LoveCode' => 'required_if:Donation,1|max:7',
            'Print' => 'in:'.implode(',', ECPayPrintMark::getConstantValues()->toArray()),
            'DelayDay' => 'int|min:0|max:15',
            'InvType' => 'in:'.implode(',', ECPayInvType::getConstantValues()->toArray())
        ]);
        return $validator;
    }
}