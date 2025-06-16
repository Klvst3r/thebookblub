<?php

namespace app\controllers;


use Yii; //Objeto principal de la palicación

use yii\web\Controller;

use app\models\User;

use Exception;

class BookController extends controller {

    public function actionNew(){
        $user = new User;

        if($user->load(Yii::$app->request->post())){
            //Hay algo en POST que es para mi.
            if($user->validate()){
                //Lo que cargue valido bien
                if($user->save()){
                    //Lo que vlide se salvo en la BD
                    Yii::$app->session->setFlash("success", 'usuasrio guardado correctamente');


                }else{
                    throw new Exception("Error al salvar el usuario");
                    return;
                }
            }

        }

        return $this->render('new.tpl', ['user' => $user]);
    }

}