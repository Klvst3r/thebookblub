<?php

namespace app\models;

//se deja de extender a model
//use yii\base\Model;

use yii\db\ActiveRecord;

class Book extends ActiveRecord
{
    // public $title;
    // public $author;


    public static function tableName(){
        return 'books';
    }

    public function getID(){
        return $this->book_id;
    }
    
    public function toString() {
        return sprintf("(%d) %s", $this->id, strtoupper($this->title));
    }
}