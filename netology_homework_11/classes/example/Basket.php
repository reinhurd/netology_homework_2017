<?php

namespace example;


class Basket
{
    public $productInBasket = [];
    protected $totalPrice = 0;
    protected $totalProductPositions = 0;
    protected $totalProductQuantity = 0;
    public function putInBasket($product, $val,$i)
    {
        $this->productInBasket[$i]["product"]=$product;
        $this->productInBasket[$i]["quantity"]=$val;
    }
    public function getPriceFromBasket()
    {
        foreach ($this->productInBasket as $i=>$v)
        {
            $this->totalPrice += $this->productInBasket[$i]["product"]->getPrice() * $this->productInBasket[$i]["quantity"];
        }
        echo "Общая сумма заказа ".$this->totalPrice." рублей.";
    }
   public function getInfo()
    {
        foreach ($this->productInBasket as $i=>$v)
        {
          echo "Товар ".$this->productInBasket[$i]["product"]->getName();
          echo " по цене ".$this->productInBasket[$i]["product"]->getPrice()." рублей за штуку";
          echo " в количестве ".$this->productInBasket[$i]["quantity"]." единиц.<hr>";
        }
        $this->getPriceFromBasket();
    }
    public static function removeProduct()
    {
        setcookie('cook', "", time() - 3600);
        header("refresh:5; url=index.php");
        exit("Ваша корзина очищена, вы будете перенаправлены на главную страницу магазина через 5 секунд");
    }
}