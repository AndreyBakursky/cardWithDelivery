<?php

use app\models\Contacts;
use app\modules\cardWithDelivery\models\Delivery;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $contact Contacts */
/* @var $contactAddress Delivery */
/* @var integer $callId */
?>

<p>
    Давайте сверим адрес доставки <span class="text-warning">(диктуем адрес)</span>
</p>
<table class="table table-bordered">
    <tr>
        <th>Индекс</th>
        <td><?= $contactAddress->POST_INDEX ?></td>
    </tr>
    <tr>
        <th>Область</th>
        <td><?= $contactAddress->POST_PROVINCE ?></td>
    </tr>
    <tr>
        <th>Название района</th>
        <td><?= $contactAddress->POST_REGION ?></td>
    </tr>
    <tr>
        <th>Город сокращенно</th>
        <td><?= $contactAddress->POST_CITY_TYPE ?></td>
    </tr>
    <tr>
        <th>Город</th>
        <td><?= $contactAddress->POST_CITY_NM ?></td>
    </tr>
    <tr>
        <th>Населенный пункт сокращенно</th>
        <td><?= $contactAddress->POST_SETTLEMENT_TYPE ?></td>
    </tr>
    <tr>
        <th>Населенный пункт</th>
        <td><?= $contactAddress->POST_SETTLEMENT_NM ?></td>
    </tr>
    <tr>
        <th>Улица сокращенно</th>
        <td><?= $contactAddress->POST_STREET_TYPE ?></td>
    </tr>
    <tr>
        <th>Улица</th>
        <td><?= $contactAddress->POST_STREET ?></td>
    </tr>
    <tr>
        <th>Дом</th>
        <td><?= $contactAddress->POST_HOUSE ?></td>
    </tr>
    <tr>
        <th>Корпус/Строение</th>
        <td><?= $contactAddress->POST_CLUSTER ?></td>
    </tr>
    <tr>
        <th>Квартира</th>
        <td><?= $contactAddress->POST_FLAT ?></td>
    </tr>
</table>
<?php $form = ActiveForm::begin() ?>
<?= $form->field($contactAddress, 'isActualAddress')->radioList($contactAddress->getActualAddressOptions()) ?>
<p><b>Если адрес актуален:</b></p>
<p>
    В ближайшее время с вами свяжется курьер нашей службы доставки и согласует удобное для вас время встречи. Карту
    вы сможете активировать, позвонив в наш контакт-центр, номер будет на обратной стороне карты. Желаем вам
    приятных покупок с кредитной картой ОТП Банка. До свидания!
</p>

<?= $form->field($contactAddress, 'POST_INDEX')->textInput(['maxlength' => true]) ?>
<?= $form->field($contactAddress, 'POST_PROVINCE')->textInput(['maxlength' => true]) ?>
<?= $form->field($contactAddress, 'POST_REGION')->textInput(['maxlength' => true]) ?>
<div class="row">
    <div class="col-lg-8">
        <?= $form->field($contactAddress, 'POST_CITY_NM')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-lg-4">
        <?= $form->field($contactAddress, 'POST_CITY_TYPE')->textInput(['maxlength' => true]) ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-8">
        <?= $form->field($contactAddress, 'POST_SETTLEMENT_NM')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-lg-4">
        <?= $form->field($contactAddress, 'POST_SETTLEMENT_TYPE')->textInput(['maxlength' => true]) ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-8">
        <?= $form->field($contactAddress, 'POST_STREET')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-lg-4">
        <?= $form->field($contactAddress, 'POST_STREET_TYPE')->textInput(['maxlength' => true]) ?>
    </div>
</div>
<?= $form->field($contactAddress, 'POST_HOUSE')->textInput(['maxlength' => true]) ?>
<?= $form->field($contactAddress, 'POST_CLUSTER')->textInput(['maxlength' => true]) ?>
<?= $form->field($contactAddress, 'POST_FLAT')->textInput(['maxlength' => true]) ?>
<p>
    <b><?= $contact->getShortName() ?></b>, укажите, пожалуйста, адрес Вашего проживания.<br>
    В ближайшее время с вами свяжется курьер нашей службы доставки и согласует удобное для вас время встречи. Карту
    вы
    сможете активировать, позвонив в наш контакт-центр, номер будет на обратной стороне карты. Желаем вам приятных
    покупок с кредитной картой ОТП Банка. До свидания!<br>
</p>
<?= Html::submitButton('Согласен', ['class' => 'btn btn-success']) ?>
<?php ActiveForm::end() ?>
