<?php

namespace example;


class Order extends Basket
{
    public function __construct ($a)
    {
        $this->productInBasket=$a;
    }
    
    public function getOrder()
    {
        foreach ($this->productInBasket as $i=>$v)
        {
            echo "Вы заказали ".$this->productInBasket[$i]["product"]->getName();
            echo " в количестве ".$this->productInBasket[$i]["quantity"]." единиц.<br>";
        }
        $this->getPriceFromBasket();
        echo "Ожидайте, с вами свяжется наш менеджер чуть позже для уточнения деталей заказа.<hr>";
    }
}