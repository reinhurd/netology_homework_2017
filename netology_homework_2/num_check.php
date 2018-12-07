<form action="num_check.php" method="get">
  <p>Добрый день!</p>
  <p>Задумайте, пожалуйста, любое целое число в десятичной системе и введите его:
    <input type="text" name="num" placeholder="Место для вашего числа" style="width: 180px;"></p>
  <p>Задуманное число будет тщательно проверено на "детекторе Фибоначчи".</p>
  <p><input type="submit" value="Проверить"></p>
</form>

<?php
/*Начало кода, сначала проверки*/
if (strlen($_GET["num"])==0) //не оставлена ли форма пустой
            {
            echo "Введите число, это не страшно.";
            }
elseif (!is_numeric($_GET["num"])) //не ввелен ли текст или числа не в десятичной форме
            {
            echo "Извините, сегодня мы принимаем только числа, и только десятичные. Приходите завтра или попробуйте на этот раз ввести другое число";
            }
else {$x = $_GET["num"]; //присваиваем переменной х введенное значение.
    $a = 1;
    $b = 1;
    while (true) //Запускаем бесконечный цикл
    {
        if ($a > $x) { //Задаем условия для первого прерывания
            echo '<p>Задуманное число НЕ входит в числовой ряд. Пичалька(</p>';
            break;
        }
        if ($a == $x) { //Задаем условия для второго прерывания
            echo '<p>Задуманное число входит в числовой ряд. УРА!</p>';
            break;
        }
        $c = $a; //Тело цикла, которое будет выполняться, пока не случится одно из прерываний
        $a += $b;
        $b = $c;
    }}

?>
