<html>
<head>
    <meta charset="utf-8">
</head>
<body>
<br><a href="admin.php">Вернуться к созданию и загрузке тестов</a>
<?php
error_reporting(0); //Чтобы не выдавало уведомлений
//Находим все имеющиеся тесты в заданной папке, определяя их в массив all_files
$all_files = glob('base/*.json');

if (!empty($all_files)): //Проходим массив, выводя для каждого теста его номер, через который он будет загружаться в обработчик
    foreach ($all_files as $file): ?>
    <form action="test.php" method="GET">
        <fieldset>
        <legend><?=str_replace(array("base/",".json"), '', $file);?></legend>
        <p><input type="hidden" name="test_number" value="<?=array_search($file, $all_files);?>"></p>
        <p><input type="submit" name="get_testing" value="Пройти тестирование"></p>
        </fieldset>
    </form>
<?php
   //     endif;
    endforeach;
endif;
if (empty($all_files))
{
    echo "Пока не загружено ни одного теста";
}
?>
</body>
</html>