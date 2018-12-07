<form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
    <p>Добрый день!</p>
    <p>Хотите внести данные в телефонную книгу? Тогда заполните, пожалуйста, все поля ниже, и нажмите "Добавить"</p>
    <input type="text" name="firstname" placeholder="Имя">
    <input type="text" name="lastname" placeholder="Фамилия">
    <input type="text" name="address" placeholder="Адрес">
    <input type="text" name="phonenumber" placeholder="Номер телефона">
    <p><input type="submit" name="send" value="Добавить"></p>
    <p>Если вы хотите вывести все ранее введенные данные, воспользуйтесь кнопкой "Показать"</p>
    <p><input type="submit" name="receive" value="Показать"></p>
</form>

<?php
$file = "phonebase.json";

//Если пользователь захотел добавить запись в телефонную книгу
if (isset($_POST['send']))
{
    if (strlen($_POST["firstname"])==0||strlen($_POST["lastname"])==0||strlen($_POST["address"])==0||strlen($_POST["phonenumber"])==0)
    {
        exit("Пожалуйста, заполните все поля формы для добавления");
    }
    elseif (file_exists($file))  //Если файл с базой уже существует, выгружаем существующую базу
    {
        $phonebase=json_decode(file_get_contents($file), true);
    }
    $phonedata["firstname"]=$_POST["firstname"];
    $phonedata["lastname"]=$_POST["lastname"];
    $phonedata["address"]=$_POST["address"];
    $phonedata["phonenumber"]=$_POST["phonenumber"];
    $phonebase[]=$phonedata;
    file_put_contents($file, json_encode($phonebase));
    echo "Контакт ".$_POST["firstname"]." добавлен в телефонную книгу!";
}

//Если пользователь захотел посмотреть существующие записи
if (isset($_POST["receive"])&&(!file_exists($file)))
{
        exit("Телефонной книги не обнаружено. Возможно, она еще не создана.");
}
//Настало время отображать полученные результаты!)
if (isset($_POST["receive"])&&file_exists($file)):
$phonebase=json_decode(file_get_contents($file), true); ?>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <div>
        <h1>Телефонная книга</h1>
        <div>
            <table>
                    <tr>
                        <th>Имя</th>
                        <th>Фамилия</th>
                        <th>Адрес</th>
                        <th>Телефон</th>
                    </tr>
                <?php foreach ($phonebase as $phonedata):?>
                    <tr>
                        <td><?=$phonedata['firstname']; ?></td>
                        <td><?=$phonedata['lastname']; ?></td>
                        <td><?=$phonedata['address']; ?></td>
                        <td><?=$phonedata['phonenumber']; ?></td>
                    </tr>
                <?php endforeach;?>
            </table>
        </div>
    </div>
</body>
<?php endif;?>