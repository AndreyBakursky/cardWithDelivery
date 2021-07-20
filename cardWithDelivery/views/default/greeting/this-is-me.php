<?php

use app\models\Contacts;
use yii\bootstrap\Collapse;
use yii\web\View;

/* @var $this View */
/* @var $contact Contacts */
/* @var integer $callId */
?>

<p>
    Вам удобно сейчас разговаривать?
</p>
<?= Collapse::widget([
    'items' => [
        [
            'label' => 'Да',
            'content' => $this->render('this-is-me/yes',
                [
                    'contact' => $contact,
                    'callId' => $callId
                ]
            )
        ],
        [
            'label' => 'Нет',
            'content' => $this->render('this-is-me/no',
                [
                    'contact' => $contact,
                    'callId' => $callId
                ]
            )
        ],
        [
            'label' => 'Отказ от разговора',
            'content' => $this->render('this-is-me/abandon', ['contact' => $contact])
        ]
    ]
]) ?>


