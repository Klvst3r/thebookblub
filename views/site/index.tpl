<h1>Índice de sitio</h1>

{if $isGuest}
  Hola invitado, {$loginLink nofilter}
{else}
  Hola {$username}
{/if}

<p>Total de libros registrados: {$bookCount}</p>