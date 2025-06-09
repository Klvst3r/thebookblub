<?php

namespace app\controllers;


use Yii; //Objeto principal de la palicación

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
            //return "Libro no encontrado";
            //return $this->redirect(['site/index']);

            Yii::$app->session->setFlash('error', 'ese libro no existe');

            // Podemos sustituir con el siguiente shortcut
            return $this->goHome();
        }
        return $book->title;
    }
}