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
    
    public function getAuthor(){
        //se relaciona el autor con el libro    author.author_id / book.author_id
        return $this
            ->hasOne(Author::class, ['author_id' => 'author_id'])
            ->one();
    }

    public function toString() {
        return sprintf("(%d) %s - %s", 
            $this->id, 
            $this->title,
            $this->getAuthor()->name,
        );
    }
}