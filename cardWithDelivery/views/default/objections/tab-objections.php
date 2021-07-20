<?php

use app\models\Contacts;
use yii\bootstrap\Collapse;
use yii\web\View;

/* @var $this View */
/* @var $contact Contacts */
?>
<?= Collapse::widget([
    'items' => [
        [
            'label' => 'Высокая % ставка по безналичному расчету',
            'content' => $this->render('tab-objections/hign-non-cash-rate', ['contact' => $contact]),
        ],

        [
            'label' => 'Высокая % ставка по снятию наличных',
            'content' => $this->render('tab-objections/hign-cash-with-drawal-rate', ['contact' => $contact]),
        ],
        [
            'label' => 'Потребительский кредит лучше',
            'content' => $this->render('tab-objections/consumer-credit', ['contact' => $contact]),
        ],
        [
            'label' => 'Мне сейчас не надо/не актуально/не интересно',
            'content' => $this->render('tab-objections/not-interesting')
        ],
        [
            'label' => 'Финансовые трудности',
            'content' => $this->render('tab-objections/finance-problem', ['contact' => $contact])
        ],
        [
            'label' => 'Есть карта другого банка',
            'content' => $this->render('tab-objections/card-another-bank')
        ],
        [
            'label' => 'Кредитная карта - это долговая яма/ не люблю кредитные карты ',
            'content' => $this->render('tab-objections/not-trust-credit-card')
        ],
        [
            'label' => 'Негде тратить/нет магазинов, где можно расплатиться картой ',
            'content' => $this->render('tab-objections/nowhere-spend')
        ],
        [
            'label' => 'Недостаточный кредитный лимит ',
            'content' => $this->render('tab-objections/low-credit-limit')
        ]
    ]
]) ?>
