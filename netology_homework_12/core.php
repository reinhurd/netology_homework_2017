<?php

require_once 'config.php';

function classAutoLoad($className)
{
	$path = __DIR__ . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . $className. '.php';
	require_once $path;
}

spl_autoload_register('classAutoLoad');