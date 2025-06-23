<?php

namespace app\models;

//se deja de extender a model
//use yii\base\Model;

use yii\db\ActiveRecord;

class Nationality extends ActiveRecord
{

    public static function tableName(){
        return 'nationalities';
    }

    public function getID(){
        return $this->book_id;
    }

}    