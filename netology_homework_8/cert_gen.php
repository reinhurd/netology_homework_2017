<?php
error_reporting(0);
session_id($_COOKIE['session_id']);
session_start();
if (empty($_SESSION["name"])||($_SESSION["test"]!=="done")) //Защита от тех, кто специально перешел на страницу без авторизации и прохождения теста
{
    http_response_code(403);
    echo "<br><br> 403! Доступ запрещен! <br> Вы будете перемещены назад через 5 секунд!";
    header("refresh: 5; url=index.php");
    exit();
}
$font=__DIR__.'/fonts/times.ttf'; //Путь до серверной папки со шрифтами.
header("Content-type: image/png"); //Нельзя выводить теги html до header, иначе в данном случае все виснет.
$gb=$_POST["gb"];
$text = $_SESSION["name"];
$im = imagecreatefrompng("certificate.png");
$color = imagecolorallocate($im, 0, 0, 0);
imagettftext ($im, 20, 0, 100, 500, $color, $font, $text." прошел тест и ответил правильно на следующее количество вопросов: $gb");
imagepng($im);//Выводим изображение
imagedestroy($im);
?>