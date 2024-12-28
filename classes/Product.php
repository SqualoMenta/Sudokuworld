<?php

class Product
{
    private $id;
    private $name;
    private $price;
    private $description;
    private $img;
    private $sellerId;

    public function __construct($id, $name, $price, $description, $img, $sellerId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
        $this->img = $img;
        $sellerId = $sellerId;
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
}
