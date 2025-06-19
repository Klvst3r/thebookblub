{use class="yii\helpers\Html"}

{if $flash}
    <div class="alert alert-success">
        {$flash}
    </div>
{/if}

<h1>{$book->title|escape}</h1>

<p>Un libro escrito por <strong>{$book->author->name|escape}</strong>.</p>

<p>{Html::a('Tengo este libro', ['book/i-own-this-book', 'book_id' => $book->id]) nofilter}</p>

<p>{Html::a('Regresar a la lista', ['book/all'], ['class' => 'btn btn-primary']) nofilter}</p>
