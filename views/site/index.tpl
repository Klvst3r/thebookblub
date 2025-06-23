{use class="yii\helpers\Html"}

<h1>Índice de sitio</h1>

{if $isGuest}
  <p>Hola invitado, {$loginLink nofilter}</p>
{else}
  <p>Hola {$username} 👋</p>
{/if}

<p>Total de libros registrados: {$bookCount}</p>

<p>
  {Html::a("Ver todos los libros", ['book/all'])} |
  {Html::a("Ver todos los autores", ['author/all'])}
</p>

<h3>Acciones:</h3>
<ul>
  <li>{Html::a('Crear libro', ['book/new'])}</li>
  <li>{Html::a('Agregar autor', ['author/new'])}</li>
</ul>