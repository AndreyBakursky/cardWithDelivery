<?php

use app\models\Contacts;
use app\modules\cardWithDelivery\models\Callback;
use yii\bootstrap\Tabs;
use yii\web\View;

/* @var $this View */
/* @var $callback Callback */
/* @var $contact Contacts */
/* @var integer $callId */
?>
<div class="wrap">
    <?= $this->render('header', ['contact' => $contact]) ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2">
                <?= $this->render('_menu', ['callId' => $callId]) ?>
            </div>
            <div class="col-lg-10">
                <div class="default-objections">
                    <?= Tabs::widget([
                        'items' => [
                            [
                                'label' => 'Вопросы',
                                'content' => $this->render('objections/tab-questions', ['contact' => $contact])
                            ],
                            [
                                'label' => 'Возражения',
                                'content' => $this->render('objections/tab-objections', ['contact' => $contact])
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

