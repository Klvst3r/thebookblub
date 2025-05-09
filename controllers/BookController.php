<?php

namespace app\controllers;

use yii\web\Controller;

use app\models\Book;

class BookController extends controller {
    public function actionAll(){
        $books = Book::find()->all();
        return serialize($books);
    }

    public function actionDetail($id){
        $book = Book::findOne($id);

        if(empty($book)){
            //TODO: Error
            return "Libro no encontrado";
        }
        return $book->title;
    }
}