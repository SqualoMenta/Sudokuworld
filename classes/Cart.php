<?php

class Cart
{
    private $products = [];
    public function __construct($products)
    {
        $this->products = $products;
    }

    public function getProducts()
    {
        return $this->products;
    }
}
