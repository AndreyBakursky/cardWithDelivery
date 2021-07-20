<?php

use app\models\Calls;
use app\models\Contacts;
use app\modules\cardWithDelivery\models\ContactCentersSearch;
use app\modules\cardWithDelivery\models\OfferParams;
use yii\bootstrap\Collapse;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Pjax;

/* @var $this View */
/* @var integer $callId */
/* @var $call Calls */
/* @var $contact Contacts */
/* @var $contactOfferParams OfferParams */
/* @var $allOffices ActiveDataProvider */
/* @var $searchModel ContactCentersSearch */
/* @var $oneOffice ActiveDataProvider */
/* @var $allOfficesChangedForDo ActiveDataProvider */
/* @var string $idWidgetAddressChange */
/* @var array $dataContactCenters */
?>

<?php if ($contactOfferParams->getOfferOfficeId()): ?>
    <p>
        Вам удобно будет подойти в наше отделение по адресу:
    </p>
    <?php
    $this->registerJs(
        '$("address-previous").ready(function(){
                $("#new_note").on("pjax:end", function() {
                $.pjax.reload({container:"#notes"});  //Reload GridView
            });
        });'
    );
    ?>

    <?php Pjax::begin([
        'id'=>'address-previous',
        'timeout' => 10000,
    ]); ?>
    <?= GridView::widget(
            [
                'dataProvider' => $oneOffice,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'OFFICE_TYPE',
                    'ORGANIZATION_NM',
                    'PHONE_NO',
                    'ADDRESS_LINE_TXT',
                    'SETTLEMENT_NM',
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
    <?= Collapse::widget([
        'items' => [
            [
                'label' => 'Отделение удобно',
                'content' => $this->render('address-previous/department-comfortably',
                    [
                            'callId' => $callId,
                            'call' => $call,
                            'contact' => $contact,
                            'contactOfferParams' => $contactOfferParams,
                            'idWidgetAddressChange' => $idWidgetAddressChange ?? null
                    ]
                )
            ],
            [
                'label' => 'Отделение не удобно',
                'content' => $this->render('address-previous/department-not-comfortably',
                    [
                            'callId' => $callId,
                            'call' => $call,
                            'contact' => $contact,
                            'allOffices' => $allOfficesChangedForDo ?? $allOffices,
                            'searchModel' => $searchModel,
                            'contactOfferParams' => $contactOfferParams,
                            'dataContactCenters' => $dataContactCenters,
                            'idWidgetAddressChange' => $idWidgetAddressChange ?? null
                    ]
                )
            ],
        ]
    ]) ?>
<?php else: ?>
    <?= $this->render('address-previous/department-not-comfortably',
        [
            'callId' => $callId,
            'call' => $call,
            'contact' => $contact,
            'allOffices' => $allOfficesChangedForDo ?? $allOffices,
            'searchModel' => $searchModel,
            'contactOfferParams' => $contactOfferParams,
            'dataContactCenters' => $dataContactCenters,
            'idWidgetAddressChange' => $idWidgetAddressChange ?? null
        ]
    ) ?>
<?php endif ?>



