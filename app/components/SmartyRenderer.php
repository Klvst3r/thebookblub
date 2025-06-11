<?php

namespace app\components;

use yii\smarty\ViewRenderer;
use yii\helpers\Html;

class SmartyRenderer extends ViewRenderer
{
    public function init()
    {
        parent::init();

        // Aseguramos que Smarty esté inicializado
        $this->smarty->registerClass('Html', Html::class);
    }
}
