<?php

use app\models\ContactParams;
use app\models\Contacts;
use app\modules\cardWithDelivery\models\Callback;
use yii\bootstrap\Collapse;
use yii\web\View;

/* @var $this View */
/* @var $callback Callback */
/* @var $contact Contacts */
/* @var integer $callId */
/* @var $contactAddress ContactParams */
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
                    Вы ранее пользовались кредитными картами?
                </p>
                <div class="default-presentation">
                    <?= Collapse::widget([
                        'items' => [
                            [
                                'label' => 'Да',
                                'content' => $this->render('presentation/yep', ['callId' => $callId])
                            ],
                            [
                                'label' => 'Нет',
                                'content' => $this->render('presentation/nope',
                                    [
                                            'contact' => $contact,
                                            'callId' => $callId
                                    ]
                                )
                            ],
                            [
                                'label' => 'Сверка адреса после согласия КЛ',
                                'content' => $this->render('presentation/success-address',
                                    [
                                        'contact' => $contact,
                                        'contactAddress' => $contactAddress,
                                        'callId' => $callId
                                    ]
                                )
                            ],
                            [
                                'label' => 'Условия тарифа 17_12',
                                'content' => $this->render('presentation/tariff-conditions')
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

