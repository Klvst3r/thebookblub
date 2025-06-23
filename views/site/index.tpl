{use class="yii\helpers\Html"}

<h1>Índice de sitio</h1>

{if $isGuest}
  <p>Hola invitado, {$loginLink nofilter}</p>
{else}
 {*Sustituimos*}
  {* {assign "user" Yii::$app->user->identity} *}
  {* por *}
 {if $user}
  <p>Hola {$user->username} 👋</p>
{/if}


  {* el sig en HPp se veria algo como $user = Yii::$app->... *}
  
  {* No exste ni votesCount ni votesAvg para ello lo estalecemos en el modelo de User*}
  <p>Has votado {$user->votesCount} veces 
  y promedio de {$user->votesAvg}</p>


{/if}

<p>Total de libros registrados: {$bookCount}</p>
<p>Total de autores registrados: {$author_count}</p>


<p>
  {Html::a("Ver todos los libros", ['book/all'])} |
  {Html::a("Ver todos los autores", ['author/all'])}
</p>

<h3>Acciones:</h3>
<ul>
  <li>{Html::a('Crear libro', ['book/new'])}</li>
  <li>{Html::a('Agregar autor', ['author/new'])}</li>
</ul>