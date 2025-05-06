<?php

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;

//Debe traers por que no estan en el mismo namespace, no estan en la misma carpeta, se deben traer otros objetos que estan en otro namespace, cada vez que se utilicen.

use app\models\Book;

use app\models\Author;


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

<<<<<<< HEAD
            //Se verifica que el author no exista en la BD, Indicando:

            //Traeme en el metodo estatico find, where 
            //ActiveQuery find where, name el author = data [2]
            //con esto, al modelo de author, estamos extendiendo activeRecord, sifnifica que hay funcionalidades que estan ahi por tener una clase tipo author.
            $author = Author::find()->where(['name' => $data[2]])->one();

            
=======
            //Antes de crear u libro vamos a crear un autor,
            //Antes de crear un autor, vamos a ver si ese autor, no existe en la bd.
            $author = Author::find()
              ->where(['name' => $data[2]])
              ->one(); //active query

              if(empty($author)) {
                //si no existe el autor, lo creamos
                $author = new Author;
                 $author->name = $data[2];
                $author->save();
              }



>>>>>>> mvc


            //print_r($data);
            //Se crea un nuevo book
            $book = new Book; //Se instancia un book, creando un active record

            $book->title = $data[1]; //se le agnga el titulo
            //$book->author = $data[2]; //esta relacion se hara despues

            //Regresamos invocamos a la funcion quick y despues lo imprime
            //$book = $this->quick($book);

            $book->author_id = $author->id;

            //Es necesario guardar la información, para ello.
            $book->save();//se salva

            printf("%s\n", $book->toString());


          } 

          
        }
        fclose($f);
        return ExitCode::OK;
    }
    

    public function getAuthor($autor_id) {
      // $author = Author::find()->where(['author_id' => $autor_id])->one();
      $author = Author::findOne($autor_id);

      if($author) {
        printf("No existe el autor con id %d\n", $autor_id);
      } else {
        return ExitCode::DATAERR;
      }

      printf("Nombre: %s\n", $author->name);
      return ExitCode::OK;
    }
}

