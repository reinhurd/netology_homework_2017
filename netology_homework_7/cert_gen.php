<?php
error_reporting(0);
$font=__DIR__.'/fonts/times.ttf'; //Указать полный путь до серверной папки со шрифтами.
header("Content-type: image/png"); //Нельзя выводить теги html до header, иначе в данном случае все виснет.
$gb=$_POST["gb"];
$text = $_POST["user_name"];
$im = imagecreatefrompng("certificate.png");
$color = imagecolorallocate($im, 0, 0, 0);
imagettftext ($im, 20, 0, 100, 500, $color, $font, $text." прошел тест и ответил правильно на следующее количество вопросов: $gb");
imagepng($im);//Выводим изображение
imagedestroy($im);
?>