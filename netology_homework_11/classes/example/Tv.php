<?php

namespace example;

class Tv extends Product implements TvGetters
{
    private $type;
    private $diagonal;
    public $price=200;
    public $category="Телевизоры";
    public function __construct($type, $diagonal)
    {
        $this->type = $type;
        $this->diagonal = $diagonal;
    }
    public function getType()
    {
        return $this->type;
    }
    public function getDiagonal()
    {
        return $this->diagonal;
    }
}