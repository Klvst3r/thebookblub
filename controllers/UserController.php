<?php

namespace app\controllers;


use Yii; //Objeto principal de la palicación

use yii\web\Controller;

use app\models\User;

use Exception;

use yii\web\HttpException;

use yii\widgets\ActiveForm;

use yii\helpers\Html;

class UserController extends controller {

    public function actionNew()
    {
        $user = new User();

        if ($user->load(Yii::$app->request->post()) && $user->validate() && $user->save()) {
            Yii::$app->session->setFlash("success", 'Usuario guardado correctamente');
            return $this->redirect(['site/login']);
        }

        ob_start();
        $form = \yii\widgets\ActiveForm::begin(['id' => 'new-user']);

        echo $form->field($user, 'username');
        echo $form->field($user, 'password')->passwordInput(); // 👈 Aquí el campo de contraseña

        echo \yii\helpers\Html::submitButton('Guardar', ['class' => 'btn btn-primary']);
        \yii\widgets\ActiveForm::end();

        $formHtml = ob_get_clean();

            //return $this->render('new.tpl', ['user' => $user]);
            //return $this->render('new.tpl');
            //return $this->render('new', ['user' => $user]);

        return $this->render('new.tpl', [
            'formHtml' => $formHtml
        ]);
    }

}