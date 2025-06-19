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


    public function attributeLabels(){
        return [
            'title' => 'Titulo',
        ];
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
            //$this->getAuthor()->name,
            //$this->author->name
            $this->author ? $this->author->name : 'Autor desconocido' //protegemos el acceso a $this->author->name en caso de que no haya relación
            //Esto evitará errores si el author_id del libro no tiene coincidencia en la tabla authors.
        );
    }

    public function rules()
    {
        return [
            [['title', 'author_id'], 'required'], // usa el validador 'required'
            ['author_id', 'integer'],             // validador correcto
        ];
    }
}