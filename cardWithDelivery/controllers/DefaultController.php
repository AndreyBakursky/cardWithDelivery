<?php

namespace app\modules\cardWithDelivery\controllers;

use Yii;
use app\models\ContactCenters;
use app\modules\cardWithDelivery\contactParamsInstallers\ContactParamInstaller;
use app\modules\cardWithDelivery\models\ContactCentersSearch;
use app\modules\cardWithDelivery\models\ContactCentersSearchSecond;
use app\modules\cardWithDelivery\models\ContactCentersSearchThird;
use app\modules\cardWithDelivery\models\Notes;
use app\models\CallsResults;
use app\models\ContactParams;
use app\modules\cardWithDelivery\models\OfferParams;
use app\models\Phones;
use app\modules\cardWithDelivery\statusInstallers\AddressWithStatusInstaller;
use app\modules\cardWithDelivery\statusInstallers\CallStatusInstaller;
use app\modules\cardWithDelivery\models\CallResult;
use app\models\Calls;
use app\modules\cardWithDelivery\models\CallContacts;
use app\modules\cardWithDelivery\models\DeclineForm;
use app\modules\cardWithDelivery\models\Callback;
use app\modules\cardWithDelivery\models\Delivery;
use yii\data\ActiveDataProvider;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Default controller for the `cardWithDelivery` module
 */
class DefaultController extends Controller
{
    public $layout = '@app/modules/cardWithDelivery/views/layouts/main';

    /**
     * @throws NotFoundHttpException
     * @throws BadRequestHttpException
     * @throws Exception
     */
    public function actionIndex()
    {
        $identity = Yii::$app->user->identity;
        $request = Yii::$app->request;
        $requestGet = Yii::$app->request->get();

        if (empty($requestGet['session_id'])) {
            throw new BadRequestHttpException('Запрос не содержит идентификатор сессии');
        }

        $model = Calls::findBySessionId($requestGet['session_id']);

        if (!$model) {

            $extId = $requestGet['ext_id'];

            if (null === $extId) {
                throw new BadRequestHttpException('Не передан параметр extId');
            }

            $extIdExp = explode('.', $extId);

            if (empty($extIdExp[1])) {
                throw new BadRequestHttpException('Параметр extId не содержит contactId');
            }

            if (empty($extIdExp[2])) {
                throw new BadRequestHttpException('Параметр extId не содержит phoneId');
            }

            $contactId = $extIdExp[1];
            $phoneId = $extIdExp[2];

            $contact = CallContacts::findOne($contactId);

            if (!$contact) {
                throw new NotFoundHttpException('Контакт не найден');
            }

            $phone = $contact->getCallPhones()
                ->where(['ID_PHONE' => $phoneId])
                ->one();

            $model = new Calls;
            foreach ($requestGet as $key => $value) {
                $key = strtoupper($key);
                if ($model->hasAttribute($key)) {
                    $model->setAttribute($key, $value);
                }
            }
            $model->setContact($contact);
            $model->setPhone($phone);
        }

        $model->setAttributes(
            [
                'OPERATOR_LOGIN' => $identity->getUsername(),
                'OPERATOR_IP' => $request->getUserIP(),
                'OPERATOR_USER_AGENT' => $request->getUserAgent()
            ]
        );
        $callStatus = $this->findStatusByName(CallsResults::CALL_RESULT_NAME_IN_WORK);
        $connection = Yii::$app->db;

        $repository = new CallStatusInstaller($model, $connection);
        $repository->statusUpdate($callStatus);

        return $this->redirect(
            [
                'default/wait-for-answer',
                'callId' => $model->getPrimaryKey(),
            ]
        );
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionWaitForAnswer($callId)
    {
        $call = $this->findCall($callId);
        $statuses = CallResult::find()
            ->where(['IN', 'CALL_RESULT_NAME', CallsResults::NOT_REACH_STATUSES])
            ->andWhere(['RESULT_SOURCE' => CallsResults::RESULT_SOURCE_SCRIPT])
            ->distinct()
            ->all();

        $contact = $call->contact;
        return $this->render('wait-for-answer',
            [
                'contact' => $contact,
                'callId' => $callId,
                'statuses' => $statuses
            ]
        );
    }

    /**
     * @throws \yii\base\Exception
     */
    public function actionGreeting($callId)
    {
        $call = $this->findCall($callId);
        $contact = $call->contact;
        $callback = new Callback();

        return $this->render('greeting',
            [
                'callback' => $callback,
                'callId' => $callId,
                'contact' => $contact
            ]
        );
    }

    /**
     * @throws \yii\base\Exception
     */
    public function actionPresentation($callId)
    {
        $call = $this->findCall($callId);
        $contact = $call->contact;
        $contactAddress = new Delivery();

        if ($contactAddress->load(Yii::$app->request->post())) {
            if ($contactAddress->validate() && !$contactAddress->isActualAddress()) {
                $connection = Yii::$app->db;
                $transaction = $connection->beginTransaction();
                try {
                    $callStatus = $this->findStatusByName(CallsResults::CALL_RESULT_CLIENT_AGREE);

                    $repository = new AddressWithStatusInstaller($call, $connection, $contactAddress);
                    $repository->statusUpdate($callStatus);

                    $transaction->commit();

                    return $this->redirect(['hang-up', 'callId' => $callId]);
                } catch (Exception $e) {
                    $transaction->rollBack();
                    throw $e;
                }
            }
        } else {
            $actualContactParams = $contact->getActualParams();
            $params = ArrayHelper::map($actualContactParams, 'PARAM_NAME', 'PARAM_VALUE');
            $contactAddress->setAttributes($params);
        }

        $callback = new Callback();

        return $this->render('presentation', [
                'callback' => $callback,
                'callId' => $callId,
                'contact' => $contact,
                'contactAddress' => $contactAddress
            ]
        );
    }

    /**
     * @throws \yii\base\Exception
     */
    public function actionNewPresentation($callId)
    {
        $call = $this->findCall($callId);
        $contact = $call->contact;

        $requestGet = Yii::$app->request->get();
        $officeId = $requestGet['NEW_VISIT_OFFICE'] ?? null;

        $contactOfferParams = new OfferParams();
        $actualContactParams = $contact->getActualParams();
        $params = ArrayHelper::map($actualContactParams, 'PARAM_NAME', 'PARAM_VALUE');
        $contactOfferParams->setAttributes($params);

        $isLoad = $contactOfferParams->load(Yii::$app->request->post());
        if (Yii::$app->request->isAjax && $isLoad) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($contactOfferParams);
        }
        if ($officeId || (Yii::$app->request->isPost && $isLoad)) {
            /**
             * Сохранение заметки для отработки события PJAX
             */
            $model = new Notes();

            $connection = Yii::$app->db;
            $contactParams = new ContactParams();
            $contactParams->setContact($contact);

            if ($isLoad) {
                $paramsInstall = new ContactParamInstaller($connection, ContactParams::PARAM_NAME_AGREE_VISIT_DATE, $contactOfferParams->getAgreeVisitDate());
                $paramsInstall->paramsInstall($contactParams);
                if (empty($officeId) && empty($contactOfferParams->getNewVisitOffice())) {
                    $contactParamsDefaultOffice = new ContactParams();
                    $contactParamsDefaultOffice->setContact($contact);
                    $paramsInstall = new ContactParamInstaller($connection, ContactParams::PARAM_NAME_NEW_VISIT_OFFICE, $contactOfferParams->getOfferOfficeId());
                    $paramsInstall->paramsInstall($contactParamsDefaultOffice);
                }
                $callStatus = $this->findStatusByName(CallsResults::CALL_RESULT_CLIENT_AGREE);

                $repository = new CallStatusInstaller($call, $connection);
                $repository->statusUpdate($callStatus);

                return $this->redirect(['hang-up', 'callId' => $callId]);
            }
            $paramsInstall = new ContactParamInstaller($connection, ContactParams::PARAM_NAME_NEW_VISIT_OFFICE, $officeId);
            $paramsInstall->paramsInstall($contactParams);
        }

        $dataContactCenters = $this->findContactCenters();

        $searchModel = new ContactCentersSearch();
        $secondSearchModel = new ContactCentersSearchSecond();
        $thirdSearchModel = new ContactCentersSearchThird();

        $allOffices = $searchModel->search(Yii::$app->request->queryParams);
        $allOfficesChanged = $secondSearchModel->search(Yii::$app->request->queryParams);
        $allOfficesChangedForDo = $thirdSearchModel->search(Yii::$app->request->queryParams);

        $oneOffice = new ActiveDataProvider(['query' => ContactCenters::find()
            ->where(['OFFICE_ID' => $contactOfferParams->getOfferOfficeId()]),
            'sort' => false]);

        $callback = new Callback();

        return $this->render('new-presentation', [
                'call' => $call,
                'callback' => $callback,
                'callId' => $callId,
                'contact' => $contact,
                'contactOfferParams' => $contactOfferParams,
                'allOffices' => $allOffices,
                'oneOffice' => $oneOffice,
                'searchModel' => $searchModel,
                'secondSearchModel' => $secondSearchModel,
                'thirdSearchModel' => $thirdSearchModel,
                'allOfficesChanged' => $allOfficesChanged,
                'allOfficesChangedForDo' => $allOfficesChangedForDo,
                'dataContactCenters' => $dataContactCenters
            ]
        );
    }

    /**
     * @throws \yii\base\Exception
     */
    public function actionObjections($callId)
    {
        $call = $this->findCall($callId);
        $contact = $call->contact;
        $callback = new Callback();

        return $this->render('objections', [
            'callback' => $callback,
            'contact' => $contact,
            'callId' => $callId
        ]);
    }

    /**
     * @throws \yii\base\Exception
     */
    public function actionDecline($callId)
    {
        $call = $this->findCall($callId);
        $contact = $call->contact;

        $model = new DeclineForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $callStatus = $this->findStatus($model->getStatusId());
            $connection = Yii::$app->db;

            $repository = new CallStatusInstaller($call, $connection);
            $repository->statusUpdate($callStatus);

            return $this->redirect(['hang-up', 'callId' => $callId]);
        }

        $callback = new Callback();

        return $this->render('decline', [
            'model' => $model,
            'callback' => $callback,
            'contact' => $contact,
            'callId' => $callId
        ]);
    }

    /**
     * @throws NotFoundHttpException
     * @throws Exception
     */
    public function actionCallback($callId)
    {
        $call = $this->findCall($callId);
        $contact = $call->contact;

        $callback = new Callback(['clientTimeZone' => $contact->getTimeZoneClient()]);
        $isLoad = $callback->load(Yii::$app->request->post());
        if (Yii::$app->request->isAjax && $isLoad) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($callback);
        }
        if (Yii::$app->request->isPost && $isLoad) {
            $phones = $contact->getPhones()
                ->where(['PHONE_NUMBER' => $callback->getPhoneNumber()])
                ->one();
            if (empty($phones)) {
                $contactPhones = $contact->phones;
                foreach ($contactPhones as $phone) {
                    $phone->deactivate();
                    $phone->save(false);
                }

                $callbackPhone = new Phones();
                $callbackPhone->setPhone($callback->getPhoneNumber());
                $callbackPhone->setContact($contact);
                $callbackPhone->activate();
                $callbackPhone->save(false);
            }
            $contact->setCallback($callback);
            $call->setCallback($callback);

            $callStatus = $this->findStatusByName($callback->getReason());
            $connection = Yii::$app->db;

            $repository = new CallStatusInstaller($call, $connection);
            $repository->statusUpdate($callStatus);

            return $this->redirect(['hang-up', 'callId' => $callId]);
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function actionClientRejection($callId)
    {
        $call = $this->findCall($callId);
        $statusName = Yii::$app->request->get('statusName');

        if (!is_numeric($statusName)) {
            $callStatus = $this->findStatusByName($statusName);
        } else {
            $callStatus = $this->findStatus($statusName);
        }

        $connection = Yii::$app->db;

        $repository = new CallStatusInstaller($call, $connection);
        $repository->statusUpdate($callStatus);

        return $this->redirect(['hang-up', 'callId' => $callId]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionHangUp($callId)
    {
        $call = $this->findCall($callId);
        return $this->render('hangup', ['call' => $call]);
    }

    public function findCall($callId)
    {
        $call = Calls::findOne($callId);

        if (!$call) {
            throw new NotFoundHttpException('По указанному callId = ' . $callId . ' звонок не найден!');
        }
        return $call;
    }

    public function findStatus($statusId): CallsResults
    {
        $status = CallsResults::findOne((integer)$statusId);

        if (!$status) {
            throw new NotFoundHttpException('По указанному statusId = ' . $statusId . ' статус не найден!');
        }
        return $status;
    }

    public function findStatusByName($callStatus): CallsResults
    {
        $status = CallsResults::findOne(['CALL_RESULT_NAME' => $callStatus]);

        if (!$status) {
            throw new NotFoundHttpException('По указанному statusName = ' . $callStatus . ' статус не найден!');
        }
        return $status;
    }

    public function findContactCenters()
    {
        $dataContactCenters = ArrayHelper::map(ContactCenters::find()
            ->where(['IS_ACTIVE' => ContactCenters::OFFICE_IS_ACTIVE])
            ->all(),
            'SETTLEMENT_NM', 'SETTLEMENT_NM');

        if (!$dataContactCenters) {
            throw new NotFoundHttpException('Центры обслуживания не найдены! Проверьте условия запроса и целостность бд');
        }
        return $dataContactCenters;
    }
}
