<?php

namespace app\models;

use yii\base\Model;


class Book extends Model
{
    public $title;
    public $author;
    
    public function toString() {
        return sprintf("%s - %s", $this->title, $this->author);
    }
}