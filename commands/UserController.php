<?php

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;

use app\models\User;


class UserController extends Controller {

    public function actionNew($username, $password) {
        $user = new User;
        $user->username = $username;
        $user->password = $password;
        if($user->save()){ //Si logra salvar
            printf("new user ok, id: %d\n", $username, $password);
        }else{
            printf("Problama creando usuario \n");
        }

        return ExitCode::OK;


    }

    public function checkPassword($username, $password) {

    }
}