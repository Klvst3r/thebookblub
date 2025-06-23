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
   
}