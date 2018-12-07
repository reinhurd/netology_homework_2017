<?php
//создаем массив с континентами и животными
$cont_animals = [
    "South America"=>
    [
        "Amphisbaena alba",
        "Lama glama",
        "Ramphastos",
        "Pristobrycon careospinus",
    ],
    "Africa"=>
    [
        "Bucorvus",
        "Guttera pucherani",
        "Syncerus caffer",
        "Amietophrynus pantherinus",
    ],
    "North America"=>
    [
        "Nerodia sipedon",
        "Coleonyx brevis",
        "Geosternbergia",
        "Haliaeetus leucocephalus",
    ],
    "Australia"=>
    [
        "Macropus rufus",
        "Trichosurus vulpecula Phalangeridae",
        "Lasiorhunus krefftii",
        "Thylacinus cynocephalus",
    ],
];
echo "<u>Это - наши реальные животные: </u><br>";
foreach ($cont_animals as $continents => $zveri)
{
    echo "<h2>" . $continents . "</h2>";
    echo implode(", ", $zveri) . "<br>";
};

//выведем из первого массива все двойные названия животных в отдельный массив
foreach ($cont_animals as $continents) {
    foreach ($continents as $key => $animal)
    {
        if (substr_count($animal, " ") === 1)
        {
            $Animals_two[]=$animal;
        }
    }
}

foreach ($Animals_two as $value) //пройдем второй массив и перемешаем первые слова в нем
{
    list($x[], $y[]) = explode(" ", $value); //разрываем названия животных на новые массивы
}
shuffle($y); //мешаем значения во втором из них (чтобы не мешался порядок вывода стран)

foreach ($x as $k=>$number)
{
    $animal_fantasy[] = $x[$k]." ".$y[$k]; //Третий массив создаем из перемешанных слов
}

foreach ($animal_fantasy as $elem) //определим, кто где живет, через сравнение строк первого и третьего массивов
{
    $first_fan = explode(" ", $elem); //превращаем первое имя выдуманных зверей в строку для дальнейшего сравнения
    foreach ($cont_animals as $key => $animal)
    {
        foreach ($animal as $value2)
        {
            $first_real = explode(" ", $value2); //аналогично с первым именем реальных животных
            if ($first_fan[0] === $first_real[0]) //сравниваем их тождественность
            {
                $home_animal_fantasy[$key][] = $elem; //если тождественны - в четвертый массив вписываем континент и выдуманных зверей.
            }
        }
    }
}
echo "<br><u> А это - наши фантастические создания и места их обитания: </u><br>";
foreach ($home_animal_fantasy as $continents => $fan_zveri)
{
    echo "<h2>" . $continents . "</h2>";
    echo implode(", ", $fan_zveri) . "<br>";
};
