<?php

namespace S\Sipay\Api\Payment;

use S\Sipay\Api\Payment\Models\PaymentItem;
use YG\ApiLibraryBase\Abstracts\Request\AbstractRequest;

class PrepareThreeDPayment extends AbstractRequest
{
    public static function create(): self
    {
        return new self([
            'cc_holder_name' => '',
            'cc_no' => '',
            'expiry_month' => '',
            'expiry_year' => '',
            'cvv' => '',

            'currency_code' => '',
            'installments_number' => '',

            'invoice_id' => '',
            'invoice_description' => '',

            'name' => '',
            'surname' => '',

            'total' => '',
            'items' => [],

            'cancel_url' => '',
            'return_url' => '',

            'bill_email' => '',
            'bill_phone' => '',
            'ip' => '',
            'order_type' => 0
        ]);
    }


    /**
     * @param string $holderName      Kart sahibinin adı
     * @param string $number          Kart numarsı
     * @param string $expirationMonth Kart son kullanım ayı
     * @param string $expirationYear  Kart son kullanım yılı, dört haneli olmalı
     * @param string $cvv             Kart son kullanım yılı, dört haneli olmalı
     * @param string $currencyCode    Para birimi kodu, alabileceği değerler USD, TRY, EUR
     *
     * @return $this
     */
    public function setCreditCard(string $holderName, string $number, string $expirationMonth, string $expirationYear,
                                  string $cvv, string $currencyCode = 'TRY'): self
    {
        $this->addParams([
            'cc_holder_name' => $holderName,
            'cc_no' => $number,
            'expiry_month' => $expirationMonth,
            'expiry_year' => $expirationYear,
            'cvv' => $cvv,
            'currency_code' => $currencyCode
        ]);
        return $this;
    }

    /**
     * @param string $invoiceId          Ödeme yapılacak sepetin sipariş numarası, benzersiz göndermeye dikkat edin
     * @param string $invoiceDescription Ödeme yapılacak sepete özel bir açıklama giriniz.
     *                                   Örneğin: 4578 nolu sipariş ödemesi
     *
     * @return $this
     */
    public function setInvoice(string $invoiceId, string $invoiceDescription): self
    {
        $this->addParams([
            'invoice_id' => $invoiceId,
            'invoice_description' => $invoiceDescription
        ]);
        return $this;
    }

    /**
     * @param string $name     Ürün adı
     * @param float  $price    Fiyatı
     * @param int    $quantity Miktarı
     *
     * @return $this
     */
    public function addBasketItem(string $name, float $price, int $quantity): self
    {
        $items = $this->getParam('items') ?? [];
        $items[] = [
            'name' => $name,
            'price' => $price,
            'quantity' => $quantity
        ];
        $this->setParam('items', $items);

        $total = 0;
        foreach ($items as $item)
            $total += $item['price'];

        $this->setParam('total', $total);

        return $this;
    }

    /**
     * @param int $installment Taksit sayısı
     *
     * @return $this
     */
    public function setInstallment(int $installment): self
    {
        $this->setParam('installments_number', $installment);
        return $this;
    }

    public function setPerson(string $name, string $surname): self
    {
        $this->addParams([
            'name' => $name,
            'surname' => $surname
        ]);
        return $this;
    }

    /**
     * @param string      $email
     * @param string      $phone
     * @param string|null $country Adres ülke
     * @param string|null $city    Adres şehir
     * @param string|null $state   Adres ilçe
     * @param string|null $postcode
     * @param string|null $address1
     * @param string|null $address2
     *
     * @return $this
     */
    public function setBill(string  $email, string $phone, ?string $country = null, ?string $city = null,
                            ?string $state = null, ?string $postcode = null, ?string $address1 = null,
                            ?string $address2 = null): self
    {
        $this->addParams([
            'bill_email' => $email,
            'bill_phone' => $phone,
            'bill_country' => $country,
            'bill_city' => $city,
            'bill_state' => $state,
            'bill_postcode' => $postcode,
            'bill_address1' => $address1,
            'bill_address2' => $address2
        ]);

        return $this;
    }

    /**
     * @param string $commissionBy Komisyon'u Üye işyeri karşılayacaksa "merchant", son kullanıcı karşılayacaksa "user"
     *                             gönderilmelidir.
     *
     * @return $this
     */
    public function setCommissionBy(string $commissionBy): self
    {
        $this->addParams([
            'commission_by' => $commissionBy,
            'is_commission_from_user' => '1'
        ]);
        return $this;
    }

    /**
     * @param int $orderType 0 ve 1 değerlerini alır
     *                       order_type = 1 ise, Sipay ödemeyi yineleme için doğrular. Daha sonra
     *                       recurring_payment_number, recurring_payment_cycle, recurring_payment_interval anahtarları
     *                       boş bırakılmamalıdır.
     *
     * @return $this
     */
    public function setOrderType(int $orderType): self
    {
        $this->setParam('order_type', $orderType);
        return $this;
    }

    public function setIp(string $ip): self
    {
        $this->setParam('ip', $ip);
        return $this;
    }

    public function setSuccessUrl(string $successUrl): self
    {
        $this->setParam('return_url', $successUrl);
        return $this;
    }

    public function setFailUrl(string $failUrl): self
    {
        $this->setParam('cancel_url', $failUrl);
        return $this;
    }

    public function getParams(): array
    {
        $params = parent::getParams();
        $params['items'] = json_encode($params['items'] ?? []);
        return $params;
    }
}