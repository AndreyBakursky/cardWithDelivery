<?php

use yii\bootstrap\Nav;
use yii\web\View;

/* @var $this View */
/* @var integer $callId */
?>
<?= Nav::widget([
    'items' => [
        [
            'label' => 'Установление клиента',
            'url' => ['/cardWithDelivery/default/greeting', 'callId' => $callId],
        ],
        [
            'label' => 'Новая презентация',
            'url' => ['default/new-presentation', 'callId' => $callId],
        ],
        [
            'label' => 'Презентация',
            'url' => ['default/presentation', 'callId' => $callId],
        ],
        [
            'label' => 'Работа с возражениями',
            'url' => ['default/objections', 'callId' => $callId],
        ],
        [
            'label' => 'Отказ',
            'url' => ['default/decline', 'callId' => $callId],
        ]
    ],
    'options' => ['class' => 'nav-pills nav-stacked']
]);

?>
