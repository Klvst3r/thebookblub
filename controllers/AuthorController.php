<?php

namespace app\controllers;


use Yii; 

use yii\web\Controller;

use app\models\Author;

//Aqgregamos par apoder usitlizar mayusculas y minuscilas
use yii\db\Expression;

//Activeform
use yii\widgets\ActiveForm;
use yii\helpers\Html;


use yii\helpers\ArrayHelper;
use app\models\Nationality; // Asegúrate de importar esto


class AuthorController extends Controller {

    public function actionDetail($id){
        $author = Author::findOne($id);
        if(empty($author)){
            Yii::$app->session->setFlash('warning', 'no existe ese autor');
            return $this->redirect(['author/all']); //listado de todos los autores
        }
        //return $author->toString();
        return $this->render('detail', ['author' => $author]);
    }

    public function actionAll($search = null)
    {
        if ($search !== null) {
            //Vamos a sustituir esto por algo que permita mayusculas y muinusculas, esta bien pero debe ser exacto
            // $authors = Author::find()
            //     ->where(['like', 'name', $search])
            //     ->all();

            //Aca permitimos sensibilidad a mayusculas y minusculas no importa como se escriba
             $authors = Author::find()
            ->where(['like', new Expression('LOWER(name)'), mb_strtolower($search)])
            ->all();

        } else {
            $authors = Author::find()->all();
        }
        //Salida serializada
        //return serialize($authors);
        //Lo cambiamos por formato en la salilda
          return $this->render('all.tpl', [
            'authors' => $authors,
            'authorCount' => count($authors),
        ]);
    }

    public function actionNew()
{
    if (Yii::$app->user->isGuest) {
        Yii::$app->session->setFlash('warning', 'Debes iniciar sesión para agregar un autor.');
        return $this->redirect(['site/login']);
    }

    $author = new Author();
    $flash = null;

    if ($author->load(Yii::$app->request->post()) && $author->save()) {
        Yii::$app->session->setFlash('success', 'Autor creado correctamente');
        return $this->redirect(['author/all']);
    }

    if (Yii::$app->session->hasFlash('success')) {
        $flash = Yii::$app->session->getFlash('success');
    }

    ob_start();
    $form = \yii\widgets\ActiveForm::begin();

    echo $form->field($author, 'name');

    // Dropdown para seleccionar nacionalidad y guardar el nombre
    echo $form->field($author, 'nationality')->dropDownList(
        ArrayHelper::map(Nationality::find()->all(), 'name', 'name'),
        ['prompt' => 'Seleccione una nacionalidad']
    );

    echo \yii\helpers\Html::submitButton('Guardar', ['class' => 'btn btn-success']);

    \yii\widgets\ActiveForm::end();
    $formHtml = ob_get_clean();

    return $this->render('form.tpl', [
        'formHtml' => $formHtml,
        'author' => $author,
        'flash' => $flash,
    ]);
}

    
} 