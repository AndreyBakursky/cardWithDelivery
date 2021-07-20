<?php

use app\models\Contacts;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $contact Contacts */
/* @var integer $callId */
?>

<p>
    <b><?= $contact->getShortName() ?></b>, в целях улучшения качества обслуживания наш разговор записывается<br>
    <?= Html::a('Презентация',
        [
                'default/presentation',
                'callId' => $callId
        ],
        ['class' => 'btn btn-primary']
    ) ?>
</p>
