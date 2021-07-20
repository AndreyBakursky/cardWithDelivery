<?php

use app\models\CallsResults;
use app\models\Contacts;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var integer $callId */
/* @var $contact Contacts */
?>

<p>
    <b><?= $contact->getShortName() ?></b>, спасибо большое за ответы на вопросы, мы учтем информацию, которую вы нам сообщили. Всего
        доброго. До свидания!
</p>
<p>
    <?= Html::a('Является индивидуальным предпринимателем',
        [
            'default/client-rejection',
            'callId' => $callId,
            'statusName' => CallsResults::CALL_RESULT_INDIVIDUAL_ENTREPRENEUR
        ],
        [
        'class' => 'btn btn-info'
        ]
    ) ?>
    <?= Html::a('Работает на новом месте менее 3-х месяцев',
        [
            'default/client-rejection',
            'callId' => $callId,
            'statusName' => CallsResults::CALL_RESULT_WORKING_LESS_THREE_MONTH
        ],
        [
        'class' => 'btn btn-warning'

        ]
    ) ?>
    <?= Html::a('Не работает',
        [
            'default/client-rejection',
            'callId' => $callId,
            'statusName' => CallsResults::CALL_RESULT_NOT_WORKING
        ],
        [
            'class' => 'btn btn-danger'
        ]
    ) ?>
</p>

