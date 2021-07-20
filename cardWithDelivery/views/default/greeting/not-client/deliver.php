<?php

use app\models\Contacts;
use yii\web\View;

/* @var $this View */
/* @var $contact Contacts */
?>

<p>
    Эту информацию я могу сообщить только лично. Подскажите, как я могу связаться с <b><?= $contact->getShortName() ?></b>?
</p>
