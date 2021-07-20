<?php

use app\models\Contacts;
use app\modules\cardWithDelivery\models\CallResult;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $contact Contacts*/
/* @var integer $callId */
/* @var CallResult[] $statuses */
?>

<div class="wrap">
    <?= $this->render('header', ['contact' => $contact]) ?>
    <div class="container">
        <div class="row">           
            <div class="col-lg-12">
               <p>
                    <?= DetailView::widget(
                        [
                            'model' => $contact,
                            'attributes' => [
                                'ID_CONTACT',
                                'FIRSTNAME',
                                'MIDDLENAME',
                                'LASTNAME',
                                'CREATED_AT'
                            ]
                        ]
                    ); ?>
                </p>
                <p>
                    <?= Html::a('Ответ',
                        [
                            'default/greeting',
                            'callId' => $callId
                        ],
                        ['class' => 'btn btn-success']
                    ) ?>
                    <?php foreach($statuses as $status): ?>
                            <?= Html::a($status->getCallResultName(),
                                [
                                    'default/client-rejection',
                                    'callId' => $callId,
                                    'statusName' => $status->getIdResult()
                                ],
                                ['class' => 'btn btn-primary']
                            ); ?>
                    <?php endforeach; ?>
                </p>
            </div>
        </div>
    </div>
</div>


