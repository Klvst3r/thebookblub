<?php

namespace app\controllers;


use Yii; //Objeto principal de la palicación

use yii\web\Controller;

use app\models\Book;


use yii\widgets\ActiveForm;
use yii\helpers\Html;


use app\models\Author;

use app\models\UserBook;


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
        //return $book->toString();
        $flash = null;
if (Yii::$app->session->hasFlash('success')) {
    $flash = Yii::$app->session->getFlash('success');
}

var_dump($flash); exit;

        return $this->render('detail.tpl', [
            'book' => $book,
            'flash' => $flash,
        ]);
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



    public function actionIOwnThisBook($book_id){
        //return 'chido';  //Solo loutilizamos para verificar la ruta
        //Validamos por que estamos utilizando identity
        if(Yii::$app->user->isGuest){
            return $this->goHome();
        }

        $ub =  new UserBook;

        $ub->user_id = Yii::$app->user->identity->id;
        $ub->book_id = $book_id;
        // $ub->save();
        // Yii::$app->session->setFlash('success', 'chido!');
        if ($ub->save()) {
            Yii::$app->session->setFlash('success', '¡Libro agregado a tu colección!');
        } else {
            Yii::$app->session->setFlash('error', 'No se pudo registrar el libro.');
        }


        return $this->redirect(['book/detail', 'id' => $book_id]);

    }
}