<?php

use app\models\Calls;
use app\models\ContactParams;
use app\models\Contacts;
use app\modules\cardWithDelivery\models\Callback;
use app\modules\cardWithDelivery\models\ContactCentersSearch;
use app\modules\cardWithDelivery\models\ContactCentersSearchSecond;
use yii\bootstrap\Collapse;
use yii\data\ActiveDataProvider;
use yii\web\View;

/* @var $this View */
/* @var $call Calls */
/* @var $callback Callback */
/* @var $contact Contacts */
/* @var integer $callId */
/* @var $contactOfferParams ContactParams */
/* @var $allOffices ActiveDataProvider */
/* @var $searchModel ContactCentersSearch */
/* @var $secondSearchModel ContactCentersSearchSecond */
/* @var $thirdSearchModel ContactCentersSearchSecond */
/* @var $oneOffice ActiveDataProvider */
/* @var $allOfficesChanged ActiveDataProvider */
/* @var $allOfficesChangedForDo ActiveDataProvider */
/* @var array $dataContactCenters */
?>

<div class="wrap">
    <?= $this->render('header', ['contact' => $contact]) ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2">
                <?= $this->render('_menu', ['callId' => $callId]) ?>
            </div>
            <div class="col-lg-10">
                <p>
                    У нас есть интересное предложение для вас, недоступное для других клиентов. Для того чтобы
                    воспользоваться предложением, необходимо соответствовать минимальным требованиям. Подскажите, на
                    последнем месте работы вы трудоустроены официально? <span class="text-warning">(ответ клиента)</span> Более 3х месяцев?
                </p>
                <div class="default-presentation">
                    <?= Collapse::widget([
                        'items' => [
                            [
                                'label' => 'Да',
                                'content' => $this->render('new-presentation/yes',
                                    [
                                            'contact' => $contact,
                                            'call' => $call,
                                            'callId' => $callId,
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
                            ],
                            [
                                'label' => 'Нет',
                                'content' => $this->render('new-presentation/no',
                                    [
                                            'contact' => $contact,
                                            'callId' => $callId
                                    ]
                                )
                            ],
                            [
                                'label' => 'Какая у вас процентная ставка? (прямой вопрос клиента)',
                                'content' => $this->render('new-presentation/interest-rate')
                            ],
                            [
                                'label' => 'Сколько действует предложение?',
                                'content' => $this->render('new-presentation/offer-validity-time')
                            ]
                        ]
                    ]) ?>
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

