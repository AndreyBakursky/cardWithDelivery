<?php

use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var integer $callId */
?>

<p>
    <?= Html::a('Вопросы и возражения',
        [
            'default/objections',
            'callId' => $callId
        ],
        ['class' => 'btn btn-warning']
    ) ?>
</p>