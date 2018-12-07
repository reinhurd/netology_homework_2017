<html>
<head>
    <meta charset="utf-8">
</head>
<body>
<form method="GET">
    <fieldset>
        <p>Добрый день!</p>
        <p>Что будем делать сегодня?</p>
        <p>Прочтем новости или же создадим свои?</p>
        <p><input type="submit" name="get_news" value="Прочесть"></p>
        <p><input type="submit" name="create_news" value="Создать"></p>
    </fieldset>
</form>

<?php
require_once "news.php";
require_once "functions.php";
error_reporting(0);
#error_reporting(E_ALL);
//Если выбрано Создать новость
if(isset($_GET["create_news"])): ?>
    <form method="POST">
        <fieldset>
            <p>Создание новости:</p>
            <p>Чтобы создать новость, пожалуйста, заполните все поля</p>
            <p><input type="text" name="header" placeholder="Заголовок" required></p>
            <p><input type="hidden" name="date" value="<?=date('Y-m-d');?>"></p>
            <p><input type="hidden" name="id" value="<?=uniqid();?>"></p>
            <p><textarea name="text" placeholder="Текст новости" required></textarea>
            <p><input type="text" name="author" placeholder="Автор" required></p>
            <p><input type="submit" name="save" value="Сохранить новость"></p>
        </fieldset>
    </form>
    <?php
//Сохраняем новости
    if (isset($_POST['save']))
    {
        $news = new news($_POST["id"]);
        $news->setNews($_POST["header"],$_POST["date"],$_POST["text"],$_POST["author"]);
    }
endif;

//Если выбрано Прочесть
if(isset($_GET["get_news"]))
{
    getNewsIds();
}
?>
</body>
</html>