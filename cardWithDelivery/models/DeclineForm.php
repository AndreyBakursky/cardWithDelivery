<?php

namespace app\modules\cardWithDelivery\models;

use app\models\CallsResults;
use yii\base\Model;
use yii\db\Exception;
use yii\helpers\ArrayHelper;

class DeclineForm extends Model
{
    /**
     * Customer's status
     * @var $statusId
     */
    public $statusId;

    public function rules()
    {
        return [
            [['statusId'], 'required'],
            [['statusId'], 'checkStatusId']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'statusId' => 'Статус/Причина отказа'
        ];
    }

    /**
     * @todo Правильный вариант поиска статусов отказа является по коду
     * @return array
     */
    public function getStatuses()
    {
        $models = CallResult::find()
            ->join('JOIN', RelResultGroup::tableName(), 'FID_RESULT = ID_RESULT')
            ->join('JOIN', ResultGroup::tableName(), 'ID_GROUP = FID_GROUP')
            ->where(['LIKE', 'LOWER(CALL_RESULTS_GROUPS_NAME)', 'отказ'])
            ->all();
        return ArrayHelper::map($models, 'ID_RESULT', 'CALL_RESULT_NAME');
    }

    /**
     * Проверка на наличие statusId в СallsResults
     * @throws Exception
     */
    public function checkStatusId()
    {
        $statusResult = CallsResults::findOne($this->statusId);
        if (empty($statusResult)) {
            throw new Exception('По указанному statusId = ' . $this->statusId . ' статус не найден!');
        }
    }

    public function getStatusId()
    {
        return $this->statusId;
    }
}