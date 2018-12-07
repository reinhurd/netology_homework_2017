<?php
abstract class Product //Базовый абстрактный класс
{
    protected $title;
    protected $price;
    protected $weight;
    protected $discount=0.1; //Все товары по умолчанию имеют скидку 10%

    protected $deliveryPrice=250; //Доставка на все продукты по умолчанию - 250 р.
    protected $bestseller=false; //Является ли продукт бестселлером, это свойство для разнообразия.

    //Универсальный конструктор для всех производных классов
    public function __construct($title, $price, $weight)
    {
        $this->title = $title;
        $this->price = $price;
        $this->weight = $weight;
        $this->changePrice(); //Цена изменяется со скидкой
        $this->setDeliveryPrice(); //Устанавливаем цену доставки
    }

    public function setBestseller()
    {
        $this->bestseller=true; //Если захотим отметить товар как бестселлер
    }

    public function changePrice() //Формула расчета цены от скидки
    {
        if ($this->discount != 0) //Запускается, только если скидка вообще есть
        {
            $this->price = $this->price - ($this->price * $this->discount);
        }
    }

    public function setDeliveryPrice()
    {
        if ($this->discount != 0)
        {
            $this->deliveryPrice=300; //Если на товар была скидка, то доставка - 300 р.
        }
    }
}

class InstantNoodles extends Product //Класс Лапши
{
    private $developer; //Дополнительное свойство - производитель
    public function __construct($title, $price, $weight, $developer)
    {
        parent::__construct($title, $price, $weight);
        $this->developer=$developer; //Модернизируем метод родителя, дополняя конструктор определением нового свойства
    }
}


class Condiment extends Product //Класс Приправ
{
//Ничем не отличается от абстрактного
}
trait ChangeDiscountFromWeight //Примесь для продуктов, у которых скидка зависит от веса
{
    function ChangeDiscountFromWeight()
    {
        if($this->weight > 10)
        {
            $this->discount=0.1;
//Еще раз прогоняем методы абстрактного класса по установлению цены и стоимости доставки.
            parent::changePrice();
            parent::setDeliveryPrice();
        }
    }
}
class Meat extends Product //Класс мяса
{
//У объектов данного класса есть скидка, только если вес объекта больше 10 кг.
    protected $discount=0; #Убираем скидку
    use ChangeDiscountFromWeight;
    public function __construct($title, $price, $weight)
    {
        parent::__construct($title, $price, $weight); #Используем конструктор родителя
        $this->ChangeDiscountFromWeight(); #Используем примесь, чтобы рассчитать, есть ли скидка, и пересчитать цену и доставку
    }
 }

//Если нужно проверить работоспособность класса Meat
$x=new Meat("Meat ABC", 1000, 5);
print_r($x);
echo "<hr>";
$y=new Meat("Meat DEF", 1000, 12);
print_r($y);