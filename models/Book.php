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

    public static function primaryKey()
    {
        return ['book_id'];
    }



    
    
    public function getAuthor(){
        //se relaciona el autor con el libro    author.author_id / book.author_id
        // return $this
        //     ->hasOne(Author::class, ['author_id' => 'author_id'])
        //     ->one();
            return $this->hasOne(Author::class, ['author_id' => 'author_id']);
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

    public function getVotes(){
        return $this->hasMany(BookScore::class, ['book_id' => 'book_id'])->all();
    }

    // public function getScore():float{
        public function getScore():string{
        //$score =  0;
        $i = 0; //contador
        $sum = 0; //variable que guarda la suma de los votos para despues sacar el promedio

        foreach($this->votes as $vote){
            $i++;
            $sum = $sum += $vote->score;
        }

        //return $score;
        //return $i == 0 ? 0 : $sum/$i; //Si i es igual a 0 devuelve 0 y si no devuelve promedio cuando devuelv un flotante
        
        if($i == 0){
            return "Sin votos";
        }
        return sprintf("%0.2f (%d votos)", $sum/$i, $i); 
        //El %f es el espacio para un float con dos decimales, devolviendo en lugar de un float un string

    }


    public function rules()
    {
        return [
            [['title', 'author_id'], 'required'], // usa el validador 'required'
            ['author_id', 'integer'],             // validador correcto
        ];
    }
}