<?php
function getNewsIds()
{
    $base=json_decode(file_get_contents("news.json"),true);
    foreach($base as $k=>$v)
    {
        $news = new news($k); //Передаем в конструктор значение Id класса.
        echo "<hr>";
    }
}