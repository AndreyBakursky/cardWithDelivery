<?php

use app\models\Contacts;
use yii\bootstrap\Collapse;
use yii\web\View;

/* @var $this View */
/* @var $contact Contacts */
/* @var integer $callId */
?>

<?= Collapse::widget([
    'items' => [
        [
            'label' => 'Предоставляют номер / время',
            'content' => $this->render('not-client/provide', ['contact' => $contact])
        ],
        [
            'label' => 'Расскажите мне, я передам',
            'content' => $this->render('not-client/deliver', ['contact' => $contact])
        ],
        [
            'label' => 'Отказ / не знают КЛ',
            'content' => $this->render('not-client/fault', ['callId' => $callId])
        ]
    ]
]) ?>


