<?php

use app\models\Calls;
use app\models\Contacts;
use app\modules\cardWithDelivery\models\OfferParams;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var integer $callId */
/* @var $call Calls */
/* @var $contact Contacts */
/* @var $contactOfferParams OfferParams */
/* @var string $idWidgetAddressChange */
?>

<p>
    Когда Вам будет удобно обратиться в отделение Банка сегодня или завтра?<br>
    <span class="text-warning">Если клиент не готов в эти дни подойти, спросить:</span><br>
    На следующей неделе ... или ... числа удобно будет?
</p>
<p>
    <?php $form = ActiveForm::begin([
        'enableAjaxValidation' => true,
        'action' => (['default/new-presentation', 'callId' => $callId])
    ]) ?>
        <?= $form->field($contactOfferParams, 'AGREE_VISIT_DATE')->widget(DatePicker::class, [
            'options' => [
                    'placeholder' => 'Дата встречи',
                    'id' => 'department-comfortably' . $idWidgetAddressChange
            ],
            'pluginOptions' => [
                'format' => 'dd.mm.yyyy',
                'language' => 'ru',
                'todayHighlight' => true,
                'startDate' => $call->getStartDate(),
                'endDate' => strtotime($contactOfferParams->dateOfferValidTo()) < strtotime($call->getEndDate()) ?
                    $contactOfferParams->dateOfferValidTo() : $call->getEndDate()
            ],
            'pluginEvents' => [
                "changeDate" => "function(e) { $('b.meeting-date').text($(e.currentTarget).find('input').val()); }",
            ],
        ]); ?>
    <b><?= $contact->getShortName() ?></b>, итак, мы ждем Вас в нашем отделении
    <b class="meeting-date"></b>. Обязательно возьмите с собой паспорт!
    Всего Доброго, до свидания!<br>
    <?= Html::submitButton('Согласен', ['class' => 'btn btn-success']) ?>
    <?php ActiveForm::end() ?>
</p>
