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

}