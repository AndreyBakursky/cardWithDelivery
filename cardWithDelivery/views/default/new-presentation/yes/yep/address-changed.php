<?php

use app\models\Calls;
use app\models\Contacts;
use app\modules\cardWithDelivery\models\ContactCentersSearch;
use app\modules\cardWithDelivery\models\ContactCentersSearchSecond;
use app\modules\cardWithDelivery\models\OfferParams;
use kartik\select2\Select2;
use yii\bootstrap\Collapse;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\web\View;
use yii\widgets\Pjax;

/* @var $this View */
/* @var integer $callId */
/* @var $call Calls */
/* @var $contact Contacts */
/* @var $contactOfferParams OfferParams */
/* @var $allOffices ActiveDataProvider */
/* @var $searchModel ContactCentersSearch */
/* @var $secondSearchModel ContactCentersSearchSecond */
/* @var $thirdSearchModel ContactCentersSearchSecond */
/* @var $oneOffice ActiveDataProvider */
/* @var $allOfficesChanged ActiveDataProvider */
/* @var $allOfficesChangedForDo ActiveDataProvider */
/* @var array $dataContactCenters */
?>

<p>
    <b><?= $contact->getShortName() ?></b>, уточните, пожалуйста Регион Вашего проживания?
    <span class="text-warning">Проверяем, не входит ли названный регион Клиента в список где нет ДО. Для назначения
    встречи в торговой точке, выбрать адрес "Торговая точка".</span>
</p>
<?php
    $this->registerJs(
        '$("address-changed").ready(function(){
                    $("#new_note").on("pjax:end", function() {
                    $.pjax.reload({container:"#notes"});  //Reload GridView
                });
            });'
    );
?>

<?php Pjax::begin([
    'id' => 'address-changed',
    'timeout' => 10000,
]); ?>
    <?= GridView::widget(
        [
            'dataProvider' => $allOfficesChanged,
            'filterModel' => $secondSearchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'OFFICE_TYPE',
                'ORGANIZATION_NM',
                'PHONE_NO',
                'ADDRESS_LINE_TXT',
                [
                    'attribute' => 'SETTLEMENT_NM',
                    'filter' => Select2::widget([
                        'model' => $secondSearchModel,
                        'attribute' => 'SETTLEMENT_NM',
                        'data' => $dataContactCenters,
                        'value' => $secondSearchModel->getSettlementNm(),
                        'options' => [
                            'class' => 'form-control',
                            'placeholder' => 'Город'
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'selectOnClose' => true,
                        ]
                    ])
                ]
            ]
        ]
    );
    ?>
<?php Pjax::end() ?>
<?= Collapse::widget([
    'items' => [
        [
            'label' => 'Регион, где есть ДО',
            'content' => $this->render('../yep/address-previous',
                [
                    'contactOfferParams' => $contactOfferParams,
                    'callId' => $callId,
                    'call' => $call,
                    'contact' => $contact,
                    'allOffices' => $allOffices,
                    'allOfficesChangedForDo' => $allOfficesChangedForDo,
                    'searchModel' => $thirdSearchModel,
                    'oneOffice' => $oneOffice,
                    'dataContactCenters' => $dataContactCenters,
                    'idWidgetAddressChange' => 'change'
                ]
            )
        ],
        [
            'label' => 'Регион, где нет ДО',
            'content' => $this->render('address-changed/region-has-not-do',
                [
                    'callId' => $callId,
                    'contact' => $contact
                ]
            )
        ]
    ]
]) ?>
