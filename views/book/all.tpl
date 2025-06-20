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


