<html>
<head>
    <meta charset="utf-8">
</head>
<body>
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
            <br> 2.Четыре варианта ответов, ключи которых названы "answer_1"-"answer_4".
            <br> 3.Подмассив "true" с 4 элементами без ключей, где позиции правильных ответов помечены фразой "on".
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
                    !array_key_exists("answer_3",$i)||
                    !array_key_exists("answer_4",$i)||
                    !array_key_exists("true",$i)||
                    !in_array("on",$i["true"])
                )
                {
                    exit ("Извините, ваш тест не соответствует заданным требованиям");
                }
            }
            if (move_uploaded_file(($_FILES["testfile"]["tmp_name"]), "base/".($_FILES["testfile"]["name"])))
            {
                header("refresh: 5; url=list.php");
                echo "Спасибо, Ваш тест загружен! Вы будете перенаправлены на страницу выбора тестов через 5 секунд.";
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
        <p>У каждого вопроса может быть 4 варианта ответа, в котором от 1 до 4 вариантов ответа могут быть правильными.</p>
        <p>Вначале введите название создаваемого теста или уже существующего теста,
            к которому хотите добавить вопрос.</p>
        <p>Затем введите задаваемый вопрос и варианты ответов в соответствующие поля. Правильные варианты ответов отметьте галочкой.
            Обязательно должны быть внесены все четыре варианта ответов.</p>
        <Br><input type="text" name="quiz_name" placeholder="Название теста"><Br>
        <Br><input type="text" name="question" placeholder="Вопрос"><Br>
        <Br><input type="checkbox" name="true_1" id="check1"><label for="check1"><input type="text" name="answer_1" placeholder="Ответ 1"></label><Br>
        <Br><input type="checkbox" name="true_2" id="check2"><label for="check2"><input type="text" name="answer_2" placeholder="Ответ 2"></label><Br>
        <Br><input type="checkbox" name="true_3" id="check3"><label for="check3"><input type="text" name="answer_3" placeholder="Ответ 3"></label><Br>
        <Br><input type="checkbox" name="true_4" id="check4"><label for="check4"><input type="text" name="answer_4" placeholder="Ответ 4"></label><Br>
        <p><input type="submit" name="save" value="Сохранить тест в базу"></p>
        </fieldset>
    </form>
<?php
    //Задаем имя для сохраняемого теста
    $name = $_POST["quiz_name"];
    $file = "base/$name.json";

    if (isset($_POST['save']))
    {
        if
        (
            empty($_POST["quiz_name"])||
            empty($_POST["question"])||
            empty($_POST["answer_1"])||
            empty($_POST["answer_2"])||
            empty($_POST["answer_3"])||
            empty($_POST["answer_4"])
        )
        {
            exit("Пожалуйста, заполните все поля формы для добавления теста");
        }
        if
        (
            empty($_POST["true_1"])&&
            empty($_POST["true_2"])&&
            empty($_POST["true_3"])&&
            empty($_POST["true_4"])
        )
        {
            exit ("Пожалуйста, укажите хотя бы один правильный ответ");
        }
        if (file_exists($file))  //Если файл с тестом уже существует
        {
            $testbase=json_decode(file_get_contents($file), true);
            echo "Вопрос <b>".$_POST["question"]."</b> добавлен в тест <b>$name</b>!";
        }
        else
        {
            echo "Тест <b>$name</b> создан и туда добавлен вопрос ".$_POST["question"]."!";
        }
        $quest_data["question"]=$_POST["question"];
        $quest_data["answer_1"]=$_POST["answer_1"];
        $quest_data["true"]=[$_POST["true_1"],$_POST["true_2"],$_POST["true_3"],$_POST["true_4"]]; //Записываем метки правильных ответов в подмассив True
        $quest_data["answer_2"]=$_POST["answer_2"];
        $quest_data["answer_3"]=$_POST["answer_3"];
        $quest_data["answer_4"]=$_POST["answer_4"];
        $testbase[]=$quest_data; //Вопрос с ответами становится подмассивом в массиве теста.
        file_put_contents($file, json_encode($testbase));
    }
endif; ?>
</body>
</html>