<?php

use app\models\CallsResults;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var integer $callId */
?>

<p>
    Извините за беспокойство. Всего доброго. До свидания.
</p>
<p>
    <?= Html::a('Клиента не знают',
        [
                'default/client-rejection',
                'callId' => $callId,
                'statusName' => CallsResults::CALL_RESULT_CLIENT_NOT_KNOW
        ],
        ['class' => 'btn btn-warning']) ?>
    <?= Html::a('Клиента долго не будет',
        [
                'default/client-rejection',
                'callId' => $callId,
                'statusName' => CallsResults::CALL_RESULT_CLIENT_GONE
        ],
        ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Клиент умер',
        [
                'default/client-rejection',
                'callId' => $callId,
                'statusName' => CallsResults::CALL_RESULT_CLIENT_DIE
        ],
        ['class' => 'btn btn-danger']) ?>
</p>

