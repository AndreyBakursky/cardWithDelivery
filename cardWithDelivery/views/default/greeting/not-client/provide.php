<?php

use app\models\Contacts;
use yii\web\View;

/* @var $this View */
/* @var $contact Contacts */
?>

<p>
    <span class="text-warning">Фиксируем номер, дату и время перезвона, назначаем перезвон.</span><br>
    Спасибо! Мы свяжемся с <b><?= $contact->getShortName() ?></b> в указанное время. Всего доброго, до свидания!
</p>
