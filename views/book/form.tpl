{use class="yii\helpers\Html"}

<h1>Registrar nuevo libro</h1>

{if $flash}
    <div class="alert alert-success">
        {$flash}
    </div>
{/if}

{$formHtml nofilter}
