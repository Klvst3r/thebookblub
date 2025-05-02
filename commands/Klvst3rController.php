<?php

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;

//Debe traers por que no estan en el mismo namespace, no estan en la misma carpeta, se deben traer otros objetos que estan en otro namespace, cada vez que se utilicen.

use app\models\Book;


/**
 * Comando para clase, de prueba
 */
class Klvst3rController extends Controller {

   /**
   * Saludo
   */
  public function actionIndex()
  {
      echo "Hola desde Klvst3r!\n";
  }


    /**
   * Suma los valores de los dos parÃ¡metros
   */
    public function actionSuma($a, $b = 17) {
        $result = $a + $b;
        printf("%0.2f\n", $result);
        return ExitCode::OK;
      }


      // private function quick($book) {
      //   $book->title = sprintf("#sffff", $book-> title);
      //   return $book;
      // }

      public function actionBooks ($file) {
        $f=fopen($file, "r"); //Se abre el archivo
        while(!feof($f)) {
          $data = fgetcsv($f);

          //si existen elementos vacios se filtra mediante un if
          if(!empty($data[1]) && !empty($data[2])) {
            //print_r($data);
            //Se crea un nuevo book
            $book = new Book; //Se instancia un book, creando un active record

            $book->title = $data[1]; //se le agnga el titulo
            //$book->author = $data[2]; //esta relacion se hara despues

            //Regresamos invocamos a la funcion quick y despues lo imprime
            //$book = $this->quick($book);

            $book->author_id = 1;

            //Es necesario guardar la información, para ello.
            $book->save();//se salva

            printf("%s\n", $book->toString());


          } 

          
        }
        fclose($f);
        return ExitCode::OK;
    }
    
}