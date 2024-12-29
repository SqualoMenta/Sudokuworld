<?php

class Product
{
    private $id;
    private $name;
    private $price;
    private $description;
    private $img;
    private $sellerId;

    public function __construct($ID, $Name, $Price, $Description, $Image, $SEL_ID)
    {
        $this->id = $ID;
        $this->name = $Name;
        $this->price = $Price;
        $this->description = $Description;
        $this->img = $Image;
        $this->sellerId = $SEL_ID;
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

    public function getSellerId()
    {
        return $this->sellerId;
    }
}
