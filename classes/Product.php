<?php

class Product
{
    private $id;
    private $name;
    private $price;
    private $description;
    private $img;
    private $seller_email;
    private $category_tag;
    private $discount;
    private $availability;
    private $removed;

    public function __construct($id_product, $name, $price, $description, $image, $email, $category_tag, $discount, $availability, $removed = 0)
    {
        $this->id = $id_product;
        $this->name = $name;
        $this->price = $price / 100;
        $this->description = $description;
        $this->img = $image;
        $this->seller_email = $email;
        $this->category_tag = $category_tag;
        $this->discount = $discount;
        $this->availability = $availability;
        $this->removed = $removed;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getImg()
    {
        return $this->img;
    }

    public function getSellerEmail()
    {
        return $this->seller_email;
    }

    public function getCategoryTag()
    {
        return $this->category_tag;
    }

    public function getDiscount()
    {
        return $this->discount;
    }

    public function getAvailability()
    {
        return $this->availability;
    }

    public function isRemoved()
    {
        return $this->removed;
    }

    public function getFinalPrice($sudoku_solved)
    {
        $discountPrice = $this->price * (1 - $this->discount / 100);
        if ($sudoku_solved) {
            $discountPrice = $discountPrice * 0.9;
        }
        return $discountPrice;
    }

    public function getFinalDiscount($sudoku_solved)
    {
        return (1 - ($this->getFinalPrice($sudoku_solved) / $this->price)) * 100;
    }
}
