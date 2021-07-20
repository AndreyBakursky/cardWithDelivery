<?php

use app\models\Calls;
use app\models\Contacts;
use app\modules\cardWithDelivery\models\ContactCentersSearch;
use app\modules\cardWithDelivery\models\ContactCentersSearchSecond;
use app\modules\cardWithDelivery\models\OfferParams;
use yii\bootstrap\Collapse;
use yii\data\ActiveDataProvider;
use yii\web\View;

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
    Чтобы сэкономить ваше время, Банк максимально упростил процедуру получения кредита. Вся процедура будет занимать
    несколько минут, для этого вам необходимо подойти в отделение банка, предоставить только паспорт и получить деньги.
    Ваш регион проживания остался прежним?
</p>
<?= Collapse::widget([
    'items' => [
        [
            'label' => 'Да, прежним',
            'content' => $this->render('yep/address-previous',
                [
                    'callId' => $callId,
                    'call' => $call,
                    'contact' => $contact,
                    'contactOfferParams' => $contactOfferParams,
                    'allOffices' => $allOffices,
                    'searchModel' => $searchModel,
                    'oneOffice' => $oneOffice,
                    'dataContactCenters' => $dataContactCenters,
                    'idWidgetAddressChange' => 'default'
                ]
            )
        ],
        [
            'label' => 'Нет, изменился',
            'content' => $this->render('yep/address-changed',
                [
                    'callId' => $callId,
                    'call' => $call,
                    'contact' => $contact,
                    'contactOfferParams' => $contactOfferParams,
                    'allOffices' => $allOffices,
                    'searchModel' => $searchModel,
                    'secondSearchModel' => $secondSearchModel,
                    'thirdSearchModel' => $thirdSearchModel,
                    'oneOffice' => $oneOffice,
                    'allOfficesChanged' => $allOfficesChanged,
                    'allOfficesChangedForDo' => $allOfficesChangedForDo,
                    'dataContactCenters' => $dataContactCenters
                ]
            )
        ]
    ]
]) ?>
