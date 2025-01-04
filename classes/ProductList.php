<?php

class ProductList
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

    public function getTotalPrice($db, $sudoku_solved)
    {
        $totalPrice = 0;
        foreach ($this->products as $p) {
            $product = new Product(...$db->getProduct($p['id_product'])[0]);
            $totalPrice += $product->getFinalPrice($sudoku_solved);
        }
        return $totalPrice;
    }
}
