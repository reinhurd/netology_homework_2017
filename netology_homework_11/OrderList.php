<?php
namespace example;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<?php
session_start();
error_reporting(0);
#error_reporting(E_ALL);
require_once 'autoload.php';

if($_POST["form_order"])
{
    $b = new Order(unserialize($_COOKIE['cook']));
    $b->getOrder();
    exit();
}
if($_POST["clear"])
{
    Basket::removeProduct();
}

?>
</body>
</html>