<?php

use app\models\ContactParams;
use app\models\Contacts;
use yii\bootstrap\Collapse;
use yii\web\View;

/* @var $this View */
/* @var $contact Contacts */
/* @var $contactAddress ContactParams */
/* @var integer $callId */
?>

<p>
    <b><?= $contact->getShortName() ?></b>, вы согласны на получение ОТП Банком вашей кредитной истории в целях проверки вашей
    благонадежности?
    <span class="text-warning">(перед выпуском карты Банк делает запрос в БКИ для принятия окончательного решения по выпуску карты)</span>
</p>
<?= Collapse::widget([
    'items' => [
        [
            'label' => 'Да',
            'content' => $this->render('success-address/yes',
                [
                    'contact' => $contact,
                    'contactAddress' => $contactAddress,
                    'callId' => $callId
                ]
            )
        ],
        [
            'label' => 'Нет',
            'content' => $this->render('success-address/no')
        ]
    ]
]) ?>

