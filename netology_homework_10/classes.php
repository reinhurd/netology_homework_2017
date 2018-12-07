<?php
class ParentForExamples
{
   public $price;
}

interface CarRequiredSpeed
{
    public function howFastGetToPlace($km, $time);
}

interface TvGetters
{
    public function getType();
    function getDiagonal();
}

interface InfoAboutPen
{
   function aboutPen();
}

interface BuildDuck
{
    function __construct($weight, $speed);
}

interface getProducts
{
    function getProducts();
}

class Car extends ParentForExamples implements CarRequiredspeed
{
    public $color;
    public $max_speed;
    public function howFastGetToPlace($km, $time) //Метод, проедет ли машина определенное растояние за желаемое время.
    {
        $need_speed=$km/$time;
        if($this->max_speed>$need_speed)
        {
            return "Машина успеет доехать";
        }
        else
        {
            return "Машина не успеет, выберите другую";
        }
    }
}
$lada_granta=new Car();
$lada_granta->color="white";
$lada_granta->max_speed=150;
$lada_granta->price=100;
$audi=new Car();
$audi->color="black";
$audi->max_speed=200;
$audi->price=300;


class Tv extends ParentForExamples implements TvGetters
{
    private $type;
    private $diagonal;
    public $price=200;

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
$LG2200=new Tv("HD", 30);
$SAMSUNG3311=new Tv("FULL HD",44);

class Pen extends ParentForExamples implements InfoAboutPen
{
    public $mark;
    public function aboutPen()
    {
        return $this->mark . ' очень крутая шариковая ручка!';
    }
}
$penPilot = new Pen();
$penPilot->mark = 'Pilot';
$penPilot->price = 120;
$penPero = new Pen();
$penPero->mark = 'Pero';
$penPero->price = 130;

class Duck extends ParentForExamples implements BuildDuck
{
    private $weight;
    private $speed;
    public $price = 166;
    public function __construct($weight, $speed)
    {
        $this->weight = $weight;
        $this->speed = $speed;
    }
    public function diffToShootDuck()
    {
        $diff=$this->speed/$this->weight;
        return $diff;
    }
}
$ducks=[];
for ($i = 1; $i <= 3; $i++)
{
    $ducks[$i]=new Duck(20+$i,20-$i);
}

class Product extends ParentForExamples implements getProducts
{
    public $name;
    public $category;
    public function getProducts()
    {
        echo $this->name . ' ' . $this->category . '' . $this->price;
    }
}
$product1 = new Product();
$product1->name = 'Samsung S8';
$product1->category = 'Телефон';
$product1->price = 60000;
$product2 = new Product();
$product2->name = 'iPhone X';
$product2->category = 'Телефон';
$product2->price = 80000;
?>