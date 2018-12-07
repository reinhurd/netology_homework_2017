<?php

header('charset=UTF-8');
error_reporting(1);
error_reporting(E_ALL);
require_once 'core.php';


$database = new MySQL($dbSettings);

$result = $database->complexQuery('books', $_POST);

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <style type="text/css">
        TABLE {
            width: 100%;
            border-collapse: collapse;
            margin: auto;
        }
        TD, TH {
            padding: 3px;
            border: 1px solid black;
        }
        TH {
            background: #b0e0e6;
        }
    </style>
</head>
<body>
<div style="text-align: center">
	<h1>Поиск книг по фильтрам</h1>
	<form action="index.php" method="POST" accept-charset="UTF-8">
		<div>
			<input type="text" name="name" id="bookName" value="<?php if(isset($_POST['name'])) echo $_POST['name'];?>" placeholder="Название книги">
			<input type="text" name="author" id="author" value="<?php if(isset($_POST['author'])) echo $_POST['author'];?>" placeholder="Автор">
			<input type="text" name="isbn" id="isbn" value="<?php if (isset($_POST['isbn'])) echo $_POST['isbn'];?>" placeholder="ISBN">
			<input type="submit" value="Поиск" />
		</div>
	</form>
</div>
<br>
	<div class="table">
		<table class="booklist">
		    <thead>
		        <th>Название</th>
		        <th>Автор</th>
		        <th>Год выпуска</th>
		        <th>Жанр</th>
		        <th>ISBN</th>
		    </thead>
		    <tbody>
			    <?php foreach($result as $tableResult): ?>
                <?php extract($tableResult); ?>
				<tr>
				  <td><?=htmlspecialchars($name)?></td>
				  <td><?=htmlspecialchars($author)?></td>
				  <td><?=htmlspecialchars($year)?></td>
				  <td><?=htmlspecialchars($genre)?></td>
				  <td><?=htmlspecialchars($isbn)?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
<?php if (empty($result)): ?>
    <h3 style="text-align: center">По вашему запросу ничего не найдено! Сейчас вы будете перенаправлены на главную страницу.</h3>
<?php
#header("refresh: 5; url=index.php");
endif; ?>
</body>
</html>

