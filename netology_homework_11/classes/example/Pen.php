<?php

namespace example;

class Pen extends Product implements InfoAboutPen
{
    public $mark;
    public $category="Ручки";
    public function aboutPen()
    {
        return $this->mark . ' очень крутая шариковая ручка!';
    }
}