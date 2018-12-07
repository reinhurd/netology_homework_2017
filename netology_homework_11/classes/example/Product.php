<?php
namespace example;

abstract class Product implements getProducts
{
    public $name;
    public $category;
    public $price;

    public function getProducts()
    {
        echo $this->name . ' //' . $this->category . ' //' . $this->price;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getPrice()
    {
        return $this->price;
    }
}