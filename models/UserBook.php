<?php

namespace app\models;

use yii\db\ActiveRecord;

class UserBook extends ActiveRecord
{

    



    public static function tableName(){
        return 'user_books';
    }

    public function getId(){
        return $this->user_book_id;
    }

    public function rules()
    {
        return [
            [['user_id', 'book_id'], 'required'],
            [['user_id', 'book_id'], 'integer'],
            [['user_id', 'book_id'], 'unique', 'targetAttribute' => ['user_id', 'book_id'], 'message' => 'Ya registraste este libro.'],
        ];
    }


}