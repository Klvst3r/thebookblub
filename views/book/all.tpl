{use class="yii\helpers\Html"}

{* <h1>Todos los libros ({$bookCount}) – 
  {if $bookCount > 2}muchos{else}pocos{/if}
</h1> *}
{* Cubrimos los 3 casos: 0, 1, 2 o más *}
<h1>Todos los libros ({$bookCount}) – 
  {if $bookCount == 0}
    ninguno
  {elseif $bookCount == 1}
    solamente
  {else}
    algunos
  {/if}
</h1>




<form method="get" action="/book/all" style="margin-bottom: 1em;">
    <input type="text" name="search" placeholder="Buscar libro..." value="{$app->request->get('search')|escape}">
    <button type="submit">Buscar</button>
</form>

{if $app->request->get('search')}
  <p>Resultados para: "<strong>{$app->request->get('search')|escape}</strong>"</p>
{/if}

{if !$books}
  <p><em>No se encontraron libros con ese título.</em></p>
{/if}



<ol>
{foreach from=$books item=book}
    <li>
        {Html::a($book->title, ['book/detail', 'id' => $book->id]) nofilter}
    </li>
{/foreach}
</ol>
