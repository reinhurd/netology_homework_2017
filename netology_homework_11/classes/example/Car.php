<?php

namespace example;

class Car  extends Product implements CarRequiredSpeed
{
    public $color;
    public $max_speed;
    public $category="Машины";
    public function howFastGetToPlace($km, $time) //Метод, проедет ли машина определенное растояние за желаемое время.
    {
        $need_speed=$km/$time;
        if($this->max_speed>$need_speed)
        {
            return "Машина успеет доехать";
        }
        else
        {
            return "Машина не успеет, выберите другую";
        }
    }
}