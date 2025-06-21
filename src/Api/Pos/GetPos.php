<?php

namespace S\Sipay\Api\Pos;

use YG\ApiLibraryBase\Abstracts\Request\AbstractRequest;

class GetPos extends AbstractRequest
{
    /**
     * @param string $creditCardNumber Kart numarsının ilk 6 hanesi;
     *                                 Tarım kartları için kart numarasının tamamı gereklidir
     * @param float  $amount           Toplam ürün tutarı
     * @param string $currencyCode     Para biriminin ISO kodudur. Örneğin, USD, TRY, EUR vb.
     * @param string $commissionBy     Komisyon'u Üye işyeri karşılayacaksa "merchant", son kullanıcı karşılayacaksa
     *                                 "user" gönderilmelidir.
     * @param bool   $isRecurring      Yinelenen ödeme için zorunludur
     * @param string $is2d             Get token API yanıtında, "is_3d" 0 ise is_2d = 1 gönderilmelidir
     */
    public static function create(
        string $creditCardNumber,
        float  $amount,
        string $currencyCode,
        string $commissionBy,
        bool   $isRecurring = false,
        string $is2d = '0'): GetPos
    {
        return new self([
            'credit_card' => $creditCardNumber,
            'amount' => $amount,
            'currency_code' => $currencyCode,
            'merchant_key' => '',
            'commission_by' => $commissionBy,
            'is_recurring' => $isRecurring,
            'is_2d' => $is2d
        ]);
    }
}