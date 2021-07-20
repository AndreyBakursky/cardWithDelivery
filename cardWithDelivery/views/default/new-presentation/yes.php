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
    Спасибо за ответ, мы ценим, что вы являетесь нашим клиентом. Рада сообщить, что Банк УЖЕ ОДОБРИЛ вам кредит
    наличными на сумму
    <b><?= $contactOfferParams->getOfferLimit() ?></b> рублей, на срок
    <b><?= $contactOfferParams->getOfferTerm() ?></b> месяцев, с ежемесячным платежом
    <b><?= $contactOfferParams->getPayment() ?></b> рублей. При этом, Вы можете выбирать не только сумму кредита, размер ежемесячного платежа и срок
    действия, но и удобную для вас дату платежа. Такие условия для вас комфортны?
</p>
<?= Collapse::widget([
    'items' => [
        [
            'label' => 'Да',
            'content' => $this->render('yes/yep',
                [
                    'contactOfferParams' => $contactOfferParams,
                    'callId' => $callId,
                    'call' => $call,
                    'contact' => $contact,
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
        ],
        [
            'label' => 'Нет',
            'content' => $this->render('yes/nope', ['callId' => $callId])
        ]
    ]
]) ?>