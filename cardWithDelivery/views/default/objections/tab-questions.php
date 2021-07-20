<?php

use app\models\Contacts;
use yii\bootstrap\Collapse;
use yii\web\View;

/* @var $this View */
/* @var $contact Contacts */
?>
<?= Collapse::widget([
    'items' => [
        [
            'label' => 'Клиент интересуется снятием наличных',
            'content' => $this->render('tab-answers/cash-with-drawal', ['contact' => $contact]),
        ],

        [
            'label' => 'Какую информацию необходимо предоставить Клиенту о Льготном периоде кредитования? ',
            'content' => $this->render('tab-answers/info-client'),
        ],

        [
            'label' => 'Карта будет выпущена с PayPass?',
            'content' => $this->render('tab-answers/card-with-paypass'),
        ],
        [
            'label' => 'Pay-сервисы на карте есть?',
            'content' => $this->render('tab-answers/pay-services')
        ],
        [
            'label' => 'Сколько составляет обслуживание по карте? ',
            'content' => $this->render('tab-answers/card-maintenance')
        ],
        [
            'label' => 'Как можно пополнять карту без комиссии? ',
            'content' => $this->render('tab-answers/without-commision')
        ]
    ]
]) ?>
