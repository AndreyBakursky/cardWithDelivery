<?php

use app\models\Contacts;
use yii\bootstrap\Collapse;
use yii\web\View;

/* @var $this View */
/* @var $contact Contacts */
/* @var integer $callId */
?>

<p>
    У нас есть интересное предложение для Вас, подскажите, в какое время Вам удобнее перезвонить?<br>
    <span class="text-warning">Фиксируем дату и время перезвона, назначаем перезвон.</span><br>
    Договорились, я перезвоню Вам! Всего доброго, до свидания!
</p>
<?= Collapse::widget([
    'items' => [
        [
            'label' => 'Да',
            'content' => $this->render('no/agree',
                [
                        'contact' => $contact,
                        'callId' => $callId
                ]
            )
        ],
        [
            'label' => 'Нет',
            'content' => $this->render('no/disagree', ['contact' => $contact])
        ]
    ]
]) ?>


