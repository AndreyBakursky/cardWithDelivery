<?php

use app\models\Contacts;
use app\modules\cardWithDelivery\models\Callback;
use yii\bootstrap\Collapse;
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
                <div class="default-greeting">
                    <div>
                        <span class="text-warning">Сделать паузу, чтобы убедиться, что установлено соединение.</span><br>
                        Добрый день, меня зовут <b>Имя оператора</b>, я представляю ОТП Банк. Я могу услышать
                        <b><?= $contact->getFullName() ?></b>?
                    </div>
                    <?= Collapse::widget(
                            [
                                'items' => [
                                    [
                                        'label' => 'Это я',
                                        'content' => $this->render('greeting/this-is-me',
                                            [
                                                    'contact' => $contact,
                                                    'callId' => $callId
                                            ]
                                        )
                                    ],
                                    [
                                        'label' => 'Я не клиент / здесь таких нет',
                                        'content' => $this->render('greeting/not-client',
                                            [
                                                    'contact' => $contact,
                                                    'callId' => $callId
                                            ]
                                        )
                                    ],
                                    [
                                        'label' => 'Бросил трубку',
                                        'content' => $this->render('greeting/threw')
                                    ]
                                ]
                            ]
                    ) ?>
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


