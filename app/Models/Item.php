<?php

namespace App\Models;

class Item
{
    public $productCode;
    public $price;

    public function __construct($productCode, $price) {
        $this->productCode = $productCode;
        $this->price = $price;
    }

}
