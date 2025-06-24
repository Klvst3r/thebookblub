<?php

namespace app\models;

use yii\db\ActiveRecord;


class Author extends ActiveRecord {
     public static function tableName(){
        return 'authors';
     }


     public function getId(){
        return $this->author_id;
     }

     public function toString(){
      return sprintf("%s (%s)", $this->name, count($this->books));
     }

     public function getBooks(){
      return $this
         ->hasMany(Book::class, ['author_id' => 'author_id'])
         ->all();
     }

     public static function getAuthorList(){
      // Nos traemos a todos los autores
      $authors = self::find()->orderBy('name')->all();
       $ret = [];
         foreach (self::find()->all() as $author) {
            $ret[$author->id] = $author->name;
         }
         return $ret;
      }

      public function rules()
      {
         return [
               [['name'], 'required'],
               [['nationality'], 'string', 'max' => 100],
               [['name'], 'string', 'max' => 255],
         ];
      }

      public function getVotes($book_id = null){
         $query = $this->hasMany(BookScore::class, ['book_id' => 'book_id'])
         ->viaTable('books', ['author_id' => 'author_id']);

         if(!empty($book_id)){
            $query = $query->where(['book_id' => '$book_id']);
         }
         return $query->all();
      }
   
      public function getScore($book_id = null){
         //return 1.2;
         //return count($this->votes); //solo para comprobar el prmedio

         $i = 0;
         $sum = 0;
         $arr = $this->votes;
         if(!empty($book_id)){
            $arr = $this->getVotes($book_id);
         }
         //foreach($this->getVotes(218) as $vote) { //para el ejercicio
         foreach($this->votes as $vote) {
            $i++;
            $sum += $vote->score;
         }
         if($i == 0){
            return 'Sin votos';
         }
         return sprintf("%0.2f (%d votos)", $sum/$i, $i);
      }
}