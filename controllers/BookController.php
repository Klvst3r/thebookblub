<?php

namespace app\controllers;


use Yii; //Objeto principal de la palicación

use yii\web\Controller;

use app\models\Book;


use yii\widgets\ActiveForm;
use yii\helpers\Html;


use app\models\Author;


class BookController extends controller {
    public function actionAll(){
        $books = Book::find()->all();
        //return serialize($books);
        return $this->render('all.tpl', ['books' => $books, 'titulo' => 1]);
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
        // return $book->title;
        return $book->toString();
    }

  public function actionNew()
    {
        if(Yii::$app->user->isGuest){
            return $this->goHome();
        }

        $book = new Book();
        $flash = null;

        if ($book->load(Yii::$app->request->post()) && $book->save()) {
            Yii::$app->session->setFlash('success', 'Libro creado correctamente');
            return $this->redirect(['book/all']);
        }

        // Captura el flash (si existe) para pasarlo a la vista
        if (Yii::$app->session->hasFlash('success')) {
            $flash = Yii::$app->session->getFlash('success');
        }

        ob_start();
        $form = \yii\widgets\ActiveForm::begin();

        echo $form->field($book, 'title');
        echo $form->field($book, 'author_id')->dropDownList(Author::getAuthorList());
        //echo $form->field($book, 'published_date')->input('date');
        //echo $form->field($book, 'isbn');
        echo \yii\helpers\Html::submitButton('Guardar', ['class' => 'btn btn-success']);

        \yii\widgets\ActiveForm::end();
        $formHtml = ob_get_clean();

        return $this->render('form.tpl', [
            'formHtml' => $formHtml,
            'book' => $book,
            'flash' => $flash,
        ]);
    }
}