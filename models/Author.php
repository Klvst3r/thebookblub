<?php

namespace app\models;

use yii\db\ActiveRecord;

<<<<<<< HEAD

class Author extends ActiveRecord {

    public static function tableName(){
        return 'authors';
    }

    public function getId(){
        return $this->author_id;
    }
=======
class Author extends ActiveRecord {
     public static function tableName(){
        return 'authors';
     }


     public function getId(){
        return $this->author_id;
     }
>>>>>>> mvc

}