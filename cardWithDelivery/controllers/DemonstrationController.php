<?php

namespace app\modules\cardWithDelivery\controllers;

use app\modules\cardWithDelivery\models\CallContacts;
use app\modules\cardWithDelivery\models\CallPhones;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\web\Controller;
use Yii;

/**
 * Controller for SoftPhone Technology
 */
class DemonstrationController extends Controller
{

    public $layout = '@app/modules/cardWithDelivery/views/layouts/main';

    public function actionIndex()
    {
        /* @var \app\models\Users $identity */
        $identity = Yii::$app->user->identity;
        $model = CallContacts::find()
            ->join('JOIN', CallPhones::tableName(), 'FID_CONTACT = ID_CONTACT')
            ->select([
                'ID_CONTACT',
                'ID_PHONE',
                'PHONE_NUMBER'
            ])
            ->addSelect(['DIALER_EXT_ID' => new Expression("'otp.' || ID_CONTACT || '.' || ID_PHONE")])
            ->asArray()
            ->limit(10);

        $dataProvider = new ActiveDataProvider(['query' => $model]);
        return $this->render('index', [
                'dataProvider' => $dataProvider,
                'identity' => $identity
        ]);
    }
}