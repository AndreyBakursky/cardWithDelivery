<?php

use app\models\Calls;
use app\models\Contacts;
use app\modules\cardWithDelivery\models\ContactCentersSearch;
use app\modules\cardWithDelivery\models\OfferParams;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this View */
/* @var integer $callId */
/* @var $call Calls */
/* @var $contact Contacts */
/* @var $allOffices ActiveDataProvider */
/* @var $searchModel ContactCentersSearch */
/* @var $contactOfferParams OfferParams */
/* @var string $idWidgetAddressChange */
/* @var array $dataContactCenters */
?>

<p>
    Давайте выберем удобное для Вас отделение Банка?<br>
    <span class="text-warning">Подбираем офис, исходя из адреса Клиента. Для назначения встречи в торговой точке, выбрать
    адрес "Торговая точка"</span>
</p>

<?php
$this->registerJs(
    '$("department-not-comfortably").ready(function(){  
                $("#new_note").on("pjax:end", function() { 
                $.pjax.reload({container:"#notes"});
            });
        });'
);
?>

<?php Pjax::begin([
    'id' => 'pjax-department-not-comfortably',
    'timeout' => 10000,
]); ?>
<?= GridView::widget(
    [
        'dataProvider' => $allOffices,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'OFFICE_TYPE',
            'ORGANIZATION_NM',
            'PHONE_NO',
            'ADDRESS_LINE_TXT',
            [
                'attribute' => 'SETTLEMENT_NM',
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'SETTLEMENT_NM',
                    'data' => $dataContactCenters,
                    'value' => $searchModel->getSettlementNm(),
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => 'Город',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'selectOnClose' => true,
                    ]
                ])
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{custom}',
                'buttons' => [
                    'custom' => function ($url, $model, $key) use ($callId, $idWidgetAddressChange) {
                        $id = 'custom-' . $key . $idWidgetAddressChange;
                        $options = [
                                'id' => $id,
                                'class' => 'btn btn-info'
                        ];
                        $js = <<<JS
                            $("#{$id}").on("click", function (event) {  
                                    alert("Вы выбрали ККО для клиента. Не забудьте указать дату визита в отделение!");
                                }
                            );
                        JS;
                        $this->registerJs($js, View::POS_READY, $id);
                        return Html::a('Выбрать', [
                                'default/new-presentation',
                                'callId' => $callId,
                                'NEW_VISIT_OFFICE' => $model['OFFICE_ID'],
                            ],
                            $options
                        );
                    }
                ]
            ]
        ]
    ]
);
?>
<?php Pjax::end() ?>
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
            'id' => 'department-not-comfortably' . $idWidgetAddressChange
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
        <b><?= $contact->getShortName() ?></b>, итак, мы ждем Вас в нашем отделении <b class="meeting-date"></b>.
        Обязательно возьмите с собой паспорт! Всего Доброго, до свидания!<br>
    <?= Html::submitButton('Согласен', ['class' => 'btn btn-success']) ?>
    <?php ActiveForm::end() ?>
</p>
