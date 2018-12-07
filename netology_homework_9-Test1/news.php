<?php
class news implements \Serializable
{
    private $id;
    private $header;
    private $date;
    private $text;
    private $author;

    private $file="news.json";
    private $base;

    public function __construct($id)
    {
//Принимаем уникальный Id, генерируемый либо при создании новости, либо взыстый из массива при ее загрузке
        $this->id = $id;
        $this->base = json_decode(file_get_contents($this->file),true);
//Проходим массив с базой новостей, и выводим те новости, чьи Id такие же, как у нашего объекта
       foreach($this->base as $k=>$v)
        {
            if($k===($this->id))
            {
                $news=unserialize($v);
                $news->getNews();
            }
        }
    }

    public function setNews($header, $date, $text, $author)
    {
        $this->header = $header;
        $this->date = $date;
        $this->text = $text;
        $this->author = $author;
        $this->save();
    }

    public function save()
    {
//Ключом в массиве становится уникальный Id, а значением - сериализованный объект.
        $this->base["$this->id"] = serialize($this);
        file_put_contents($this->file, json_encode($this->base));
        echo "Успешно записано";
    }

    public function getNews()
    {
        echo "Заголовок: ".$this->header."<br><br>";
        echo "Дата: ".$this->date."<br><br>";
        echo "Новость: ".$this->text."<br><br>";
        echo "Автор: ".$this->author."<br><hr>";
    }

    public function serialize()
    {
        return serialize
        ([
            $this->id,
            $this->header,
            $this->date,
            $this->text,
            $this->author,
        ]);
    }
    public function unserialize($data)
    {
        list
            (
            $this->id,
            $this->header,
            $this->date,
            $this->text,
            $this->author,
            ) = unserialize($data);
    }
}