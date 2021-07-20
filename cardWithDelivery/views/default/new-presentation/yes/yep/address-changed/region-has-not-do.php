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
    <b><?= $contact->getShortName() ?></b>, благодарим Вас за предоставленную информацию, мы обязательно ее учтем
    при разработке специального предложения для Вас в дальнейшем.<br>
    Всего доброго. До свидания!
</p>
<p>
    В регионе клиента нет ДО -
    <?= Html::a('Завершить звонок',
        [
            'default/client-rejection',
            'callId' => $callId,
            'statusName' => CallsResults::CALL_RESULT_REGION_HAS_NOT_DO
        ],
        [
            'class' => 'btn btn-danger'
        ]
    ) ?>
</p>
<p>
    <span class="text-warning">В случае прямого вопроса - зачем вы мне звонили? Отвечаем:</span><br>
    <b><?= $contact->getShortName() ?></b>, мы хотели уточнить Ваши данные, чтобы в дальнейшем могли разработать для Вас специальное предложение.
</p>
