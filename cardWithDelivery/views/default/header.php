<?php

use app\models\Contacts;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $contact Contacts */
/* @var $dataProvider ActiveDataProvider */
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-5">
            <?= Html::img('/web/img/logo.png') ?>
        </div>
        <div class="col-lg-7">
            https://www.otpbank.ru<br>
            <b>8-800-100-55-55</b>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th scope="col">ID контакта</th>
                        <th scope="col">ФИО контакта</th>
                        <th scope="col">Часовой пояс</th>
                        <th scope="col">Время клиента</th>
                        <th scope="col">Дата создания клиента</th>
                    </tr>
                    <tr>
                        <td><?= $contact->getContactId() ?></td>
                        <td><?= $contact->getFullNameMerged() ?></td>
                        <td><?= $contact->getTimeZoneClient() ?></td>
                        <td><?= $contact->getContactTime() ?></td>
                        <td><?= $contact->getCreatedAt() ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>



