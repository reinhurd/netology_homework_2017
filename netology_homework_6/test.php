<head>
    <meta charset="utf-8">
</head>
<br><a href="list.php">Вернуться к выбору тестов</a>
<br><a href="admin.php">Вернуться к созданию и загрузке тестов</a>
<?php
error_reporting(0); //Чтобы не выдавало уведомлений
//Если пользователь зашел случайно - посылаем его на страницу выбора тестов
if (is_null($_GET["test_number"]))
{
    header("Location: list.php");
    exit;
}

//Загружаем тест, исходя из номера GET-запроса, из массива со всеми тестами
$all_tests = glob("base/*.json");
$number = $_GET["test_number"];
$test = json_decode(file_get_contents($all_tests[$number]), true);

if (isset($number)): ?>
    <p>Ответьте, пожалуйста, на следующие вопросы.</p>
    <p>Как будете готовы, нажмите кнопку "Проверить".</p>
    <p>Вы всегда можете вернуться на страницу выбора тестов или их загрузки, нажав внизу по соответствующим ссылкам.</p>
    <p>Помните - на каждый вопрос может быть несколько правильных ответов,  вы должы выбрать их все, невыбранный правильный ответ засчитывается, как ошибка.
Если вы выбрали ошибочный вариант при выбранных правильных, ответ на вопрос вам также не будет засчитан.</p>
    <form method="POST">
        <?php foreach($test as $key => $answers): ?>
            <fieldset>
                <legend><?=$answers["question"];?></legend>
        <?php $n=count($answers)-2; //Выводим все ответы через цикл for.-2 - потому что два элемента массива - это сам вопрос и сборник ответов на него.
           for ($i=1; $i<=$n; $i++): ?>
                <Br><input type="checkbox" name="answ_<?=$key;?>_<?=$i;?>" id="check<?=$i;?>"><label for="check<?=$i;?>"><?=$answers["answer_$i"];?></label><Br>
        <?php endfor; ?>
            </fieldset>
        <?php endforeach; ?>
        <input type="submit" name="test_check" value="Проверить">
    </form>
<?php
endif;

$us_answer=[]; //Этот массив будет служить для записи ответов пользователя
if (isset($_POST["test_check"]))
foreach ($test as $key => $answers)
{
    $h_a=0; //Для проверки, дан ли вообще ответ для каждого вопроса
    $n=count($answers)-2;
    for ($i=1; $i<=$n; $i++)
    {
        if ($_POST["answ_".$key."_".$i]=="on")
        {
            $us_answer[$key][]=$i;
            $h_a++;
        }
    }
    if ($h_a<1)    //Проверка, отметил ли пользователь хотя бы один ответ
    {
        exit ("Необходимо выбрать хотя бы 1 вариант ответа для каждого вопроса");
    }
}
//Для проверки используется система сравнения массивов с ответами. Если есть хоть одно расхождение - ответ провален.
if (isset($_POST["test_check"]))
{
    foreach ($us_answer as $key=>$value) //Узнаем общее количество вопросов
    {
        if (empty(array_diff($us_answer[$key],$test[$key]["true_answers"]))&&empty(array_diff($test[$key]["true_answers"],$us_answer[$key])))
        {
            echo "<br>УРА! Вы <b>правильно</b> ответили на вопрос<b> ".$test[$key]["question"].".</b>";
        }
        else
        {
            echo "<br>Вы <b>неправильно</b> ответили на вопрос<b> ".$test[$key]["question"].".</b><br>";
        }
    }
}
?>
