{use class="yii\helpers\Html"}
<h1>Todos los libros {$titulo} 
{if $titulo > 2}muchos{else}pocos{/if}

</h1>

<ol>
{foreach from=$books item=book}
    <li>
        {Html::a($book->title, ['book/detail', 'id' => $book->id]) nofilter}
    </li>
{/foreach}
</ol>


Podemos verificar con:

http://localhost:7000/books


o bien el autor en especifico

http://localhost:7000/author/6


Ahora tenemos una historia completa desde crear el usuario, crear las reglas de validación y guardar.


Podemos por ultimo ordenar de la siguiente manera en el modelo de usuarios
