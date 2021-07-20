<?php

use app\models\Contacts;
use app\modules\cardWithDelivery\models\callBack;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;

/* @var $this View */
/* @var $callback Callback */
/* @var $contact Contacts */
/* @var integer $callId */
?>
<footer class="footer">
    <div class="container">
        <div class="row">
            <p>
                <span class="text-warning center-block">Время перезвона устанавливаем то, которое указал клиент. Часовой пояс будет учтен автоматически.
                    Местное время клиента XX:XX</span> – рассчитать автоматически текущее время Мск + Timezone
            </p>
            <div class="col-lg-4">
                <?php $form = ActiveForm::begin([
                    'enableAjaxValidation' => true,
                    'action' => (['default/callback', 'callId' => $callId])
                ])?>
                <?= $form->field($callback, 'dateTime')->widget(DateTimePicker::class, [
                    'options' => ['placeholder' => 'Выбрать время и дату'],
                    'pluginOptions' => [
                        'format' => 'dd.mm.yyyy HH:mm:ss',
                        'language' => 'ru',
                        'todayHighlight' => true
                    ]
                ]); ?>
                <p>
                    <b><?= $contact->getFullName() ?></b>, так как срок действия нашего предложения ограничен,
                    перезвонить в указанное вами время мы не можем. Уточните, до offer_valid_to когда можно с Вами
                    созвониться?
                </p>
                <?= $form->field($callback, 'phoneNumber')->textInput(['maxLength' => true]) ?>
                <?= $form->field($callback, 'reason')->dropDownList($callback->getReasoncallBack(), ['prompt' => 'Выберите причину отказа']) ?>
                <?= Html::submitButton('Перезвон', ['class' => 'btn btn-success']) ?>
            </div>
            <div class="col-lg-8">
                <?= $form->field($callback, 'comment')->textarea(['maxlength' => true, 'rows' => 10]) ?>
                <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>
</footer>


