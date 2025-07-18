<?php

namespace app\controllers;


use Yii; //Objeto principal de la palicación

use yii\web\Controller;

use app\models\Book;


use yii\widgets\ActiveForm;
use yii\helpers\Html;


use app\models\Author;

use app\models\UserBook;

use app\models\BookScore;

//Aqgregamos par apoder usitlizar mayusculas y minuscilas
use yii\db\Expression;


class BookController extends controller {
    public function actionAll($search = null){

        if ($search !== null) {
            //busqueda de todos los libros
            //$books = Book::find()->all();

        //Aca permitimos sensibilidad a mayusculas y minusculas no importa como se escriba
             $books = Book::find()
            ->where(['like', new Expression('LOWER(title)'), mb_strtolower($search)])
            ->all();

        } else {
            $books = Book::find()->all();
        }
        //return serialize($books);
        return $this->render('all.tpl', [
            'books' => $books,
            'bookCount' => count($books), // nombre más claro y útil
        ]);
    }

    // public function actionDetail($id){

    //     // Buscar el libro con su autor relacionado
    //     $book = Book::find()->with('author')->where(['book_id' => $id])->one();



    //     //$book = Book::findOne($id);


    //     // Por defecto, el usuario no tiene el libro
    //     $userHasBook = false;


    //     // Verificar si el libro existe
    //     if(empty($book)){
    //         //TODO: Error
    //         //return "Libro no encontrado";
    //         //return $this->redirect(['site/index']);

    //         Yii::$app->session->setFlash('error', 'ese libro no existe');

    //         // Podemos sustituir con el siguiente shortcut
    //         return $this->goHome();

    //     }

    //     // Si el usuario está autenticado, verificar si ya tiene ese libro
    //     if (!Yii::$app->user->isGuest) {
    //         $userHasBook = Yii::$app->user->identity->hasBook($book->id);
    //     }

    //     // Renderizar la vista con las variables necesarias
    //     return $this->render('detail.tpl', [
    //         'book' => $book,
    //         'userHasBook' => $userHasBook,
    //     ]);


    //     // return $book->title;
    //     //return $book->toString();
    //      $flash = null;
    //     if (Yii::$app->session->hasFlash('success')) {
    //         $flash = Yii::$app->session->getFlash('success');
    //     } elseif (Yii::$app->session->hasFlash('error')) {
    //         $flash = Yii::$app->session->getFlash('error');
    //     }

    //     return $this->render('detail.tpl', [
    //         'book' => $book,
    //         'flash' => $flash,
    //     ]);
    // }

    // public function actionDetail($id)
    // {
    //     // Buscar el libro con su autor relacionado
    //     $book = Book::find()->with('author')->where(['book_id' => $id])->one();

    //     // Verificar si el libro existe
    //     if (empty($book)) {
    //         Yii::$app->session->setFlash('error', 'Ese libro no existe');
    //         return $this->goHome();
    //     }

    //     // Verificar si el usuario tiene el libro
    //     $userHasBook = false;
    //     if (!Yii::$app->user->isGuest) {
    //         // 👇 OJO: usa 'book_id' en lugar de 'id'
    //         $userHasBook = Yii::$app->user->identity->hasBook($book->book_id);
    //     }

    //     // Leer mensajes flash si existen
    //     $flash = null;
    //     if (Yii::$app->session->hasFlash('success')) {
    //         $flash = Yii::$app->session->getFlash('success');
    //     } elseif (Yii::$app->session->hasFlash('error')) {
    //         $flash = Yii::$app->session->getFlash('error');
    //     }

    //     // Renderizar la vista con todos los datos necesarios
    //     return $this->render('detail.tpl', [
    //         'book' => $book,
    //         'userHasBook' => $userHasBook,
    //         'flash' => $flash,
    //     ]);
    // }


   public function actionDetail($id)
    {
        $book = Book::findOne($id);
        

        if (empty($book)) {
            Yii::$app->session->setFlash('error', 'Ese libro no existe');
            return $this->goHome();
        }

        $userHasBook = false;
        if (!Yii::$app->user->isGuest) {
            $userHasBook = Yii::$app->user->identity->hasBook($book->book_id ?? $book->id);
        }

        $flash = null;
        if (Yii::$app->session->hasFlash('success')) {
            $flash = Yii::$app->session->getFlash('success');
        } elseif (Yii::$app->session->hasFlash('error')) {
            $flash = Yii::$app->session->getFlash('error');
        }

        $bs  = new BookScore; //Esto es un placeholder es un sobre vacio
        $bs->book_id = $book->id; //Vamos a agregar para asegurarnos que el detail a la hora de crear el bs new, para mandarlo como parametro en la vista

        return $this->render('detail.tpl', [
            'book' => $book,
            'book_score' => $bs,
            'flash' => $flash,
            'userHasBook' => $userHasBook,
        ]);
    }


    public function actionScore(){
        $bs = new BookScore();
        //logica
        if($bs->load(Yii::$app->request->post())){
            $bs->user_id = Yii::$app->user->identity->id;
            
            if($bs->validate()){

                if($bs->save()){
                    Yii::$app->session->setFlash('success', 'gracias por tu calificación');
                    return $this->redirect(['book/detail', 'id' => $bs->book_id]);
                }
            }
        }
        return $this->redirect(['book/all']);
    }

  public function actionNew()
    {
        /*Si no esta logueado el usuario no permite registro*/ 
        // if(Yii::$app->user->isGuest){
        //     return $this->goHome();
        // }
        //modificamos por lo siguiente: 
         if (Yii::$app->user->isGuest) {
        Yii::$app->session->setFlash('warning', 'Debes iniciar sesión para poder registrar un libro.');
        return $this->redirect(['site/login']);
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

    public function actionView($id)
    {
        $book = Book::findOne($id);
        $userHasBook = Yii::$app->user->identity->hasBook($id);
        
        return $this->render('view.tpl', [
            'book' => $book,
            'userHasBook' => $userHasBook,
        ]);
    }

}