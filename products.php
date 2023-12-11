<?php

class Producto
{
    private $brand;
    private $name;
    private $stock;
    private $price;
    private $image;

    public function __construct($brand, $name, $stock, $price, $image)
    {
        $this->brand = $brand;
        $this->name = $name;
        $this->stock = $stock;
        $this->price = $price;
        $this->image = $image;
    }

    // Getters
    public function getBrand()
    {
        return $this->brand;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getStock()
    {
        return $this->stock;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getImage()
    {
        return $this->image;
    }

    // Setters (ejemplo)
    public function setBrand($brand)
    {
        $this->brand = $brand;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setStock($stock)
    {
        $this->stock = $stock;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }
}