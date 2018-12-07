<form action="<?=$_SERVER['PHP_SELF']?>" method="GET">
    <p>Добрый день!</p>
    <p>Хотите узнать прогноз погоды на сегодня?
        Тогда введите ваш город в поле ниже</p>
    <input type="text" name="city" placeholder="Название города">
    <p><input type="submit" name="button1" value="Какая сейчас погода?"></p>
    <p>Если вы не знаете, в каком вы сейчас городе, воспользуйтесь кнопкой ниже (заодно и погоду посмотрите)</p>
    <p><input type="submit" name="button2" value="Где я?"></p>
</form>
<?php
$city = "Moscow"; //Объявляем переменную Город по умолчанию, иначе сервер нетологии выдает ошибку из-за ее неопределенности
$IP = $_SERVER['REMOTE_ADDR']; //Получаем ИП пользователя, иначе будет показан город, где находится сервер.
if ($IP=="127.0.0.1")
{
    $IP=""; //Если скрипт будет запускаться на локалхосте, то он будет выдавать 127.0.0.1. Эта проверка помогает этого избежать.
}
$GAPI = file_get_contents("http://ip-api.com/json/".$IP); //Используется поиск по IP, поэтому точность невысока.
$EGAPI = json_decode($GAPI, true); //В итоге получаем массив с информацией о локальном нахождении пользователя.
if (isset($_GET["button1"])) //Нажат ли поиск по введенному названию
{
    if ((strlen($_GET["city"])==0)||(is_numeric($_GET["city"]))) //Проверка, введено ли название города
    {
        echo "Пожалуйста, введите название вашего города на английском или русском языке или воспользуйтесь кнопкой 'Где я', если потерялись";
        exit;
    }
    else
    {
        $city=$_GET["city"];
    }
}
if (isset ($_GET["button2"]))//Или же пользователь не знает, где он, и нажал вторую кнопку.
{
    $city = $EGAPI["city"];
    echo "Не удивляйтесь, вы - в $city <br>";
}

// Здесь можно изменить остальные параметры запроса. Если требуется выдача по умолчанию, можно оставить как есть
$city_s = "q=$city"; /*Определяем тип поиска. По умолчанию использован поиск по названию. Варианты =
Поиск по id с сайта погоды - "id=..."
По широте и долготе - "lat={lat}&lon={lon}"
По почтовому индексу - "zip={index},{country}". После запятой необходимо указать название страны города по ISO 3166, иначе будет поиск по США.
*/
$units = "&units=metric"; #Выдача температуры, по умолчанию в Кельвинах, "&units=imperial" - по Фаренгейту, "&units=metric" - по Цельсию.
$lang = "&lang=ru"; #Язык выдачи общего описания погоды. По умолчанию - английский.
$type = ""; #Точность поиска города по названию. По умолчанию ищет похожие, если "&type=accurate" - только строгое соответствие.
$mode = ""; #Формат выдачи результатов погоды. По умолчанию в JSON, варианты - "xml", "html".

$file = 'weathers.txt';

if (file_exists($file)&&($city==json_decode(file_get_contents($file), true)['name'])) #Проверим, существует ли уже файл и нужный ли там город
{
    $filetime = filemtime($file); #Если да, проверим, создан ли он более 60 секунд назад
    $time = microtime(true);
    $endtime = $time - $filetime;
    if ($endtime > 60)   #если более 60 секунд, обновляем
    {
        $WAPI=file_get_contents("http://api.openweathermap.org/data/2.5/weather?{$city_s}{$units}{$lang}{$type}{$mode}&APPID=5027a59730880fdb67503eddea6091b8");
        file_put_contents($file, $WAPI);
        $WAPI=file_get_contents($file);
        $EWAPI=json_decode($WAPI, true);
    }
    else #Если менее 60 секунд, берем данные сразу из него.
    {
        $WAPI=file_get_contents($file);
        $EWAPI=json_decode($WAPI, true);
    }
}
else  #если файла нет, создаем его.
{
    $WAPI=file_get_contents("http://api.openweathermap.org/data/2.5/weather?{$city_s}{$units}{$lang}{$type}{$mode}&APPID=5027a59730880fdb67503eddea6091b8");
    file_put_contents($file, $WAPI);
    $WAPI=file_get_contents($file);
    $EWAPI=json_decode($WAPI, true);
}

if (isset($_GET["button1"])||isset($_GET["button2"]))
{
    echo "<br> Немного о погоде в ".$EWAPI['name'].".<br>  Температура: ".
        $EWAPI['main']['temp'] . "&#176;C. <br>
В целом, " . $EWAPI['weather'][0]['description'] . ".<br>
Влажность " . $EWAPI['main']['humidity'] . "%.<br>
Скорость ветра " . $EWAPI['wind']['speed'] . " м/с. <br>
Давление " . round($EWAPI['main']['pressure'] *  0.75006375541921)." мм. рт. ст. <br>"; //Перевели гектопаскали в миллиметры ртутного столба и округлили
}
//А теперь найдем код, чтобы вставить с сайта погоды картинку под стать текущей погоде. Страница с описанием кодов - https://openweathermap.org/weather-conditions
$images="";
$images1=$EWAPI['weather'][0]['id'];
switch ($images1)
{
    case ($images1<=232):
        $images="11d";
        break;
    case ($images1>232&&$images1<300):
        $images="09d";
        break;
    case ($images1>322&&$images1<523):
        $images="10d";
        break;
    case ($images1>599&&$images1<623):
        $images="13d";
        break;
    case ($images1>700&&$images1<782):
        $images="50d";
        break;
    case ($images1==800):
        $images="01d";
        break;
    case ($images1==801):
        $images="02d";
        break;
    case ($images1==802):
        $images="03d";
        break;
    case ($images1==803||$images1==804):
        $images="04d";
        break;
}
//И определим время суток, потому что от него зависят иконки для отображения погоды
date_default_timezone_set($EGAPI["timezone"]); //получаем локальное время, исходя из ИП пользователя
$time = getdate();
if (($time['hours'])<8||($time['hours'])>19) //Проверяем, не ночное ли время
{
    $images = str_replace("d", "n", $images);
}
?>
<style>
    body
    {
    background-image: url(http://openweathermap.org/img/w/<?=$images?>.png);
    background-color: azure;
    background-repeat: no-repeat;
    background-position: top center;
    }
</style>
