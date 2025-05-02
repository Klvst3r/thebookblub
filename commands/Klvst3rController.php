<?php

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;



/**
 * Comando para clase, de prueba
 */
class PlatziController extends Controller {


    /**
   * Suma los valores de los dos parÃ¡metros
   */
    public function actionSuma($a, $b = 17) {
        $result = $a + $b;
        printf("%0.2f\n", $result);
        return ExitCode::OK;
      }


      public function actionBooks ($file) {
        $f=fopen($file, "r");
        while(!feof($f)) {
          $data = fgetcsv($f);
          print_r($data);
        }
        fclose($f);
        return ExitCode::OK;
    }
    
}