<?php

namespace example;

// исключения ошибки заказа
class ControlException extends \Exception 
{
    const NO_QUANTITY = 1;
}