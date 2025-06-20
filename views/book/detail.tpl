{use class="yii\helpers\Html"}
{use class="yii\widgets\ActiveForm" type="block"}
{use class="Yii"}

{if $flash}
    <div class="alert alert-info">
        {$flash}
    </div>
{/if}

<h1>{$book->title|escape}</h1>
<p>Un libro escrito por <strong>{$book->author->name|escape}</strong>.</p>


{if $userHasBook}
    <p>Ya lo tengo</p>
    
    {ActiveForm id="new-score" assign="forma" action=['book/score']}

    {$forma->field($book_score, 'score')
    ->dropdownList([
        1 => '⭐',
        2 => '⭐⭐',
        3 => '⭐⭐⭐',
        4 => '⭐⭐⭐⭐',
        5 => '⭐⭐⭐⭐⭐'
        ])}
    
    {$forma->field($book_score, 'book_id')->hiddenInput()->label(false)}

    <input type="submit" value="calificar">
    {/ActiveForm}


    {* Aquí podrías incluir el formulario para calificar o lo que necesites *}
     {*formulario->['book/score']*}
     {*1 - 5*}
    {*Ciero el formulario*}

    
{else}
    <p>
        {Html::a('Tengo este libro', ['book/i-own-this-book', 'book_id' => $book->book_id]) nofilter}
    </p>
{/if}


