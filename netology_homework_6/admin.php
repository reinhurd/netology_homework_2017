<head>
    <meta charset="utf-8">
</head>
<form method="GET">
    <fieldset>
    <p>Добрый день!</p>
    <p>Что будем делать сегодня? Пройдем какой-нибудь тест, загрузим готовый тест или попробуем создать новый?</p>
    <p><input type="submit" name="create" value="Создать тест"></p>
    <p><input type="submit" name="upload_test" value="Загрузить тест в базу"></p>
    <p><input type="submit" name="testing" value="Выбрать тест для прохождения"></p>
    </fieldset>
</form>
<?php
error_reporting(0); //Чтобы не выдавало уведомлений
//Если нажато Выбрать тест для прохождения
if(isset($_GET["testing"]))
{
    header("Location: list.php");
}

//Если нажато Загрузить тест
if(isset($_GET["upload_test"])): ?>
<form method="POST" enctype=multipart/form-data>
    <fieldset>
    <input type=file name=testfile>
    <p>Пожалуйста, выберите файл с тестом в формате JSON для загрузки в базу</p>
        <p>ВАЖНО! <br>
            <br> В загружаемом файле должно быть строго:
            <br> 1.Вопрос, с ключом "question".
            <br> 2.От двух вариантов ответов с ключами вида answer_Х, где Х - порядковый номер ответа.
            <br> 3.Подмассив "true_answers", где цифрами указаны порядковые номера правильных ответов.
            <br> В случае несоответствия данным требованиям файл загружен не будет.
        </p>
    <input type=submit name=upload value=Загрузить>
    </fieldset>
</form>
<?php
    $path_info = pathinfo("base/".($_FILES["testfile"]["name"])); //Задаем путь для сохраняемого теста
    if (isset($_POST["upload"]))
    {
        if (is_file("base/".$_FILES["testfile"]["name"])) //Есть ли уже файл с таким именем
        {
            echo "Извините, тест с таким именем уже существует";
        }
        elseif ($path_info["extension"] === "json") //Проверка расширения файла
        {

            $test_test = json_decode(file_get_contents($_FILES["testfile"]["tmp_name"]), true); //Запускаем проверки файла на соответтсвие требованиям
            foreach ($test_test as $k=>$i)
            {
                if (!array_key_exists("question", $i)||
                    !array_key_exists("answer_1",$i)||
                    !array_key_exists("answer_2",$i)||
                    !array_key_exists("true_answers",$i)||
                    (count($i["true_answers"])<1)
                   )
                {
                    exit ("Извините, ваш тест не соответствует заданным требованиям");
                }
            }
            if (move_uploaded_file(($_FILES["testfile"]["tmp_name"]), "base/".($_FILES["testfile"]["name"])))
            {
                echo "Спасибо, Ваш тест загружен!";
            }
            else
            {
                echo "Ошибка при сохранении теста";
            }
        }
        else
        {
            echo "Извините, не обнаружен файл с расширением JSON";
        }
    }
endif;

//Если нажато создать тест - генератор тестов
if(isset($_GET["create"])): ?>
    <form method="POST">
        <fieldset>
        <p>СОЗДАНИЕ ТЕСТА:</p>
        <p>Тест может состоять из неограниченного числа вопросов.
        <p>У каждого вопроса может быть неограниченное число ответов, в котором как минимум 1 вариант ответа должен быть правильным.</p>
        <p>Укажите количество желаемых вариантов ответов, и нажмите "Обновить".</p>
        <p>Затем введите название создаваемого теста или уже существующего теста,
            к которому хотите добавить вопрос.</p>
        <p>Затем введите задаваемый вопрос и варианты ответов в соответствующие поля. Правильные варианты ответов отметьте галочкой.
            Обязательно должны быть внесены все варианты ответов.</p>
        <br><input type="number" name="numb_quest" value="<?=$_POST["numb_quest"];?>" placeholder="Укажите количество вопросов в тесте"><br>
        <Br><input type="text" name="quiz_name" placeholder="Название теста"><Br>
        <Br><input type="text" name="question" placeholder="Вопрос"><Br>
<?php   $n_q=$_POST["numb_quest"];
        for ($i = 1; $i <= $n_q; $i++): ?> 
        <Br><input type="checkbox" name="true_<?=$i;?>" id="check<?=$i;?>"><label for="check<?=$i;?>"><input type="text" name="answer_<?=$i;?>" placeholder="Ответ <?=$i;?>"></label><Br>
<?php endfor;
        if ($_POST["numb_quest"]>1): ?>
        <p><input type="submit" name="save" value="Сохранить тест в базу"></p>
<?php endif; ?>
        <p><input type="submit" name="refresh" value="Обновить"</p>
        </fieldset>
    </form>
<?php
    //Задаем имя для сохраняемого теста
    $name = $_POST["quiz_name"];
    $file = "base/$name.json";

    if (isset($_POST['save']))
    {
        $g_a=0; //Для подсчета количества правильных ответов.
        for ($i = 1; $i <= $n_q; $i++)
        {
            if
            (
                empty($_POST["quiz_name"])||
                empty($_POST["question"])||
                empty($_POST["answer_$i"])
            )
            {
                exit("Пожалуйста, заполните все поля формы для добавления теста");
            }
            if
            (
                ($_POST["true_$i"]=="on") 
            )
            {
                $g_a++; //Считаем, есть ли вообще правильные ответы
            }
        }
        if ($g_a<1)
        {
            exit ("Должен быть указан хотя бы один правильный ответ");  //Если нет - прекращаем
        }
        if (file_exists($file))  //Если файл с тестом уже существует
        {
            $testbase=json_decode(file_get_contents($file), true);
            echo "Вопрос <b>".$_POST["question"]."</b> добавлен в тест <b>$name</b>!";
        }
        else
        {
            echo "Тест <b>$name</b>создан и туда добавлен вопрос ".$_POST["question"]."!";
        }
        $quest_data["question"]=$_POST["question"];
        for ($i = 1; $i <= $n_q; $i++)
        {
            $quest_data["answer_$i"]=$_POST["answer_$i"];
            if ($_POST["true_$i"]=="on")
            {
                $quest_data["true_answers"][]=$i;
            }
        }
        $testbase[]=$quest_data; //Вопрос с ответами становится подмассивом в массиве теста.
        file_put_contents($file, json_encode($testbase));
    }
endif; 
?>
