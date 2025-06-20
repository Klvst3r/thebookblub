<?php

namespace app\models;

use yii\db\ActiveRecord;

class BookScore extends ActiveRecord {
     public static function tableName(){
        return 'book_scores';
     }


     public function getId(){
        return $this->book_score_id;
     }

     //Validación
     public function rules(){
        return[
           ['score', 'required'],
           ['score', 'integer', 'min' => 1, 'max' => 5],
           ['book_id', 'default'],
        ];
     }

}