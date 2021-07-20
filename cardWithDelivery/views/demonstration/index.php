<?php

use app\models\Users;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $dataProvider ActiveDataProvider */
/* @var $identity Users */
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'ID_CONTACT',
        'ID_PHONE',
        'PHONE_NUMBER',
        'DIALER_EXT_ID',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{custom}',
            'buttons' => [
                'custom' => function ($url, $model, $key) use ($identity) {
                    return Html::a('Открыть контакт', [
                        'default/index',
                        'session_id' => str_shuffle('abcdefghigklmn12345mgfdsgm54656gm') . rand(1, 100000),
                        'caller' => $identity->getUsername(),
                        'called' => $model['PHONE_NUMBER'],
                        'ext_id' => $model['DIALER_EXT_ID']
                    ],
                        ['class' => 'btn btn-info']);
                }
            ]
        ]
    ]
]);
?>


