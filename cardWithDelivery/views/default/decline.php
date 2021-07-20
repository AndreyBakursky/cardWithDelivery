<?php

use app\models\Contacts;
use app\modules\cardWithDelivery\models\DeclineForm;
use app\modules\cardWithDelivery\models\Callback;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model DeclineForm */
/* @var $callback Callback */
/* @var integer $callId */
/* @var $contact Contacts */
?>
<div class="wrap">
    <?= $this->render('header', ['contact' => $contact]) ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2">
                <?= $this->render('_menu', ['callId' => $callId]) ?>
            </div>
                <div class="col-lg-10">
                    <div class="default-decline">
                        <p>
                            <b>Оператор: <?= $contact->getShortName() ?>, что именно Вас не устроило?</b><br>
                            <span class="text-warning">Внимательно выслушиваем ответ КЛ. Если не называет конкретных причин, продолжаем расспрашивать, выявлять причины.</span><br>
                                Позвольте перезвонить Вам позднее?
                        </p>
                    <?php $form = ActiveForm::begin() ?>
                    <?= $form->field($model, 'statusId')->dropDownList($model->getStatuses(), ['prompt' => 'Выберите статус отказа']) ?>
                        <?= Html::submitButton('Подтвердить', ['class' => 'btn btn-danger']) ?>
                    <?php ActiveForm::end() ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->render('footer',
    [
        'callback' => $callback,
        'contact' => $contact,
        'callId' => $callId
    ]
);

?>
