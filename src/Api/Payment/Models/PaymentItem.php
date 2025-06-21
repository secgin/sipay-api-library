<?php

namespace S\Sipay\Api\Payment\Models;

final class PaymentItem
{
    public string $name;

    public float $price;

    public int $quantity;

    public function __construct(string $name, float $price, int $quantity)
    {
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
    }
}