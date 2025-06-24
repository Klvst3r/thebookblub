{use class="yii\helpers\Html"}
{use class="yii\widgets\ActiveForm" type="block"}
{use class="Yii"}

{if $flash}
    <div class="alert alert-info">
        {$flash}
    </div>
{/if}

<h1>{$book->title|escape}</h1>
<p>Un libro escrito por <strong>{Html::a($book->author->name|escape, ['author/detail', 'id' => $book->author_id])}</strong>.</p>

<p> El promedio de este libro es de: {$book->getScore()}</p>

{assign "user" Yii::$app->user->identity}


{if $userHasBook}
    {Html::a('Ya no lo tengo', ['book,all'])} (no hace nada )

    {if $user->hasVotedFor($book->id)}
        
        Ya votaste, tu voto fue de: {$user->getVotedForBook($book->id)->score}.
    {else}
   
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
    {/if}


    {* Aquí podrías incluir el formulario para calificar o lo que necesites *}
     {*formulario->['book/score']*}
     {*1 - 5*}
    {*Ciero el formulario*}

    
{else}
    <p>
        {Html::a('Tengo este libro', ['book/i-own-this-book', 'book_id' => $book->book_id]) nofilter}
    </p>
{/if}


