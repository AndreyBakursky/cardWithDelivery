<?php

namespace app\modules\cardWithDelivery\models;

use app\models\ContactCenters;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class ContactCentersSearch extends ContactCenters
{
    public function rules()
    {
        return [
            [['SETTLEMENT_NM'], 'string']
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = ContactCenters::find()
            ->where(['IS_ACTIVE' => ContactCenters::OFFICE_IS_ACTIVE])
            ->asArray()
            ->limit(10);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['SETTLEMENT_NM' => $this->SETTLEMENT_NM]);

        return $dataProvider;
    }

    public function getSettlementNm()
    {
        return $this->SETTLEMENT_NM;
    }
}