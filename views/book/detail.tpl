{use class="yii\helpers\Html"}

{if $flash}
    <div class="alert alert-success">
        {$flash}
    </div>
{/if}

<h1>{$book->title|escape}</h1>
<p>Un libro escrito por <strong>{$book->author->name|escape}</strong>.</p>

{if $userHasBook}
    <p>Ya lo tengo</p>
    <p>
        {Html::a('Ya no lo tengo', ['book/i-dont-own-this-book', 'book_id' => $book->book_id]) nofilter}
    </p>

    {* Aquí podrías incluir el formulario para calificar o lo que necesites *}
     {*formulario->['book/score']*}
     {*1 - 5*}
    {*Ciero el formulario*}
{else}
    <p>
        {Html::a('Tengo este libro', ['book/i-own-this-book', 'book_id' => $book->book_id]) nofilter}
    </p>
{/if}