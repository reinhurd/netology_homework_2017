<?php
class news
{
    private $header;
    private $date;
    private $text;
    private $author;

    public function __construct($header, $date, $text, $author)
    {
        $this->header=$header;
        $this->date=$date;
        $this->text=$text;
        $this->author=$author;
    }
    public function getNews()
    {
        echo "Заголовок: ".$this->header."<br><br>";
        echo "Дата: ".$this->date."<br><br>";
        echo "Новость: ".$this->text."<br><br>";
        echo "Автор: ".$this->author."<br><hr>";
    }
}