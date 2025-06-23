{use class="yii\helpers\Html"}
{* <h1>Todos los autores ({$authorCount}) – 
{if $authorCount > 1}algunos{else}solamente{/if}
</h1> *}
{* Cambiamos por esto , para cubir los tres casos*}
<h1>Todos los autores ({$authorCount}) – 
  {if $authorCount == 0}
    ninguno
  {elseif $authorCount == 1}
    solamente
  {else}
    algunos
  {/if}
</h1>




<form method="get" action="/author/all" style="margin-bottom: 1em;">
    <input type="text" name="search" placeholder="Buscar autor..." value="{$app->request->get('search')|escape}">
    <button type="submit">Buscar</button>
</form>

{if $app->request->get('search')}
  <p>Resultados para: "<strong>{$app->request->get('search')|escape}</strong>"</p>
{/if}

{if !$authors}
  <p><em>No se encontraron autores con ese nombre.</em></p>
{/if}


<ol>
{foreach from=$authors item=author}
    <li>
        {Html::a($author->name, ['author/detail', 'id' => $author->id]) nofilter}
    </li>
{/foreach}
</ol>
