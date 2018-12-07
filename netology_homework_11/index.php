<?php
namespace example;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<?php
session_start();
error_reporting(0);
#error_reporting(E_ALL);
require_once 'autoload.php';
session_start();
//Задаем существующие товары, чтобы была возможность добавить их в корзину
$lada_granta=new Car();
$lada_granta->color="white";
$lada_granta->name="Лада Гранта";
$lada_granta->max_speed=150;
$lada_granta->price=100;
$audi=new Car();
$audi->name="Ауди";
$audi->color="black";
$audi->max_speed=200;
$audi->price=300;

$LG2200=new Tv("HD", 30);
$LG2200->name="LG2200";
$SAMSUNG3311=new Tv("FULL HD",44);
$SAMSUNG3311->name="SAMSUNG2200";

$penPilot = new Pen();
$penPilot->mark = 'Pilot';
$penPilot->price = 120;
$penPilot->name="Ручка Пилот";
$penPero = new Pen();
$penPero->mark = 'Pero';
$penPero->price = 130;
$penPero->name="Ручка Перо";

$ducks=[];
for ($i = 1; $i <= 3; $i++)
{
    $ducks[$i]=new Duck("Duck".$i,20+$i,20-$i);
}
$aviableProduct = [$lada_granta, $audi, $LG2200, $SAMSUNG3311, $penPero, $penPilot, $ducks[1], $ducks[2], $ducks[3]]; //Массив товаров, доступных в магазине
?>
<!--Функционал хтмл-формы корзины-->

<body>
<form method="POST">
    <fieldset>
        <p>Добрый день!</p>
        <p>Что вы хотите сегодня приобрести?</p>
        <p>Название//Группа//Цена в рублях</p>
<?php foreach ($aviableProduct as $k=>$value): ?>
   <Br><input type="checkbox" name="check<?=$k;?>" id="check<?=$k;?>"><label for="check<?=$k;?>"><?php $value->getProducts();?></label><Br>
   <p><input type="number" name="quantity<?=$k;?>" placeholder="Укажите количество"></p>
<?php endforeach; ?>
        <p><input type="submit" name="create_order" value="Сделать заказ"></p>
    </fieldset>
</form>
<?php
if (isset($_POST["create_order"]))
{
    $currentBasket = new Basket();
    $i=1;
    $empty=0;
    foreach ($aviableProduct as $k => $value)
    {
        if ($_POST["check".$k]==="on")
        {   
            try 
            {
                $currentBasket->putInBasket($value,$_POST["quantity".$k],$i);
                $i++;
              if (empty($_POST['quantity'.$k]))
              {
                throw new ControlException('Не указано количество товара', ControlException::NO_QUANTITY);
              }
            }
            catch (ControlException $e) 
            {
                echo "С заказом возникла проблема: ". $e->getMessage();
                die();
            }
        }
    }
    if ($i===1)
    {
        exit("Не выбран ни один товар");
    }
}

if(isset($currentBasket)):
    $a=serialize($currentBasket->productInBasket); //Передаем содержание объекта (корзину) в кукисы.
    setcookie("cook", $a); ?> 
<form action="OrderList.php" method="POST">
    <fieldset>
<p>Сейчас в вашей корзине следующие товары</p>
    <?=$currentBasket->getInfo();?>
<p>Вы можете оформить заказ или же удалить какой-нибудь товар из корзины</p>
    <input type="submit" name="clear" value="Очистить корзину">
    <input type="submit" name="form_order" value="Оформить к оплате">
    </fieldset>
</form>
<?php
endif;
?>
</body>
</html>