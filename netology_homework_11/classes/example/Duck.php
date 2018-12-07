<?php

namespace example;

class Duck extends Product implements BuildDuck
{
    private $weight;
    private $speed;
    public $price = 166;
    public $category="Утки";
    public function __construct($name, $weight, $speed)
    {
        $this->name= $name;
        $this->weight = $weight;
        $this->speed = $speed;
    }
    public function diffToShootDuck()
    {
        $diff=$this->speed/$this->weight;
        return $diff;
    }
}