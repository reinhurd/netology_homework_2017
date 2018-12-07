<?php
spl_autoload_register ('autoloadInterface');
function autoloadInterface ($InterfaceName)
{
    $fileName = __DIR__ . DIRECTORY_SEPARATOR .'interfaces'. DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $InterfaceName) . '.php';
    include_once $fileName;
}
spl_autoload_register ('autoloadClass');
function autoloadClass ($className)
{
    $fileName = __DIR__ . DIRECTORY_SEPARATOR .'classes'. DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';
    include_once $fileName;
}
?>