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


      public function actionAuthor($author_id) {
        // $author = Author::find()->where(['author_id' => $author_id])->one();
  
        $author = Author::findOne($author_id);
        if(empty($author)){
          printf("No existe el author\n");
          return ExitCode::DATAERR;
        }
        printf("%s:\n", $author->toString());
        foreach($author->books as $book){
          printf(" - %s\n", $book->toString());
        }
        return ExitCode::OK;
      }

      public function actionBook($book_id){
        $book = Book::findOne($book_id);
        
        if (empty($book)) {
            printf("No existe el libro\n");
            return ExitCode::DATAERR;
        }
    
        // Mostrar información del libro
        printf("%s\n", $book->toString());
        return ExitCode::OK;
    }
    

      public function actionBooks ($file) {
        $f=fopen($file, "r"); //Se abre el archivo
        while(!feof($f)) {
          $data = fgetcsv($f);

          //si existen elementos vacios se filtra mediante un if
          if(!empty($data[1]) && !empty($data[2])) {

            //Se verifica que el author no exista en la BD, Indicando:

            //Traeme en el metodo estatico find, where 
            //ActiveQuery find where, name el author = data [2]
            //con esto, al modelo de author, estamos extendiendo activeRecord, sifnifica que hay funcionalidades que estan ahi por tener una clase tipo author.
            $author = Author::find()
              ->where(['name' => $data[2]])
              ->one();

             


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