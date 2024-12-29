<?php

class Product
{
    private $id;
    private $name;
    private $price;
    private $description;
    private $img;
    private $seller_email;

    public function __construct($id_product, $name, $price, $description, $image, $email)
    {
        $this->id = $id_product;
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
        $this->img = $image;
        $this->seller_email = $email;
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
}
