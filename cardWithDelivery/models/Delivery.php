<?php

namespace app\modules\cardWithDelivery\models;

use yii\base\Model;

class Delivery extends Model
{
    
    public const ERROR_MESSAGE = 'Необходимо заполнить город либо населенный пункт';

    public const ACTUAL_ADDRESS_OPTIONS = [
        1 => 'Да',
        0 => 'Нет'
    ];

    /**
     * Ответ пользователя актуальны ли данные
     * @var $isActualAddress
     */
    public $isActualAddress;

    /**
     * Индекс
     * @var $POST_INDEX
     */
    public $POST_INDEX;

    /**
     * Область
     * @var $POST_PROVINCE
     */
    public $POST_PROVINCE;

    /**
     * Район
     * @var $POST_REGION
     */
    public $POST_REGION;

    /**
     * Город сокращенно
     * @var $POST_CITY_TYPE
     */
    public $POST_CITY_TYPE;

    /**
     * Название города
     * @var $POST_CITY_NM
     */
    public $POST_CITY_NM;

    /**
     * Населенный пункт сокращенно
     * @var $POST_SETTLEMENT_TYPE
     */
    public $POST_SETTLEMENT_TYPE;

    /**
     * Населенный пункт
     * @var $POST_SETTLEMENT_NM
     */
    public $POST_SETTLEMENT_NM;

    /**
     * Улица сокращенно
     * @var $POST_STREET_TYPE
     */
    public $POST_STREET_TYPE;

    /**
     * Улица
     * @var $POST_STREET
     */
    public $POST_STREET;

    /**
     * Дом
     * @var $POST_HOUSE
     */
    public $POST_HOUSE;

    /**
     * Корпус/строение
     * @var $POST_CLUSTER
     */
    public $POST_CLUSTER;

    /**
     * Квартира
     * @var $POST_FLAT
     */
    public $POST_FLAT;

    /**
     * @var mixed
     */
    public function rules()
    {
        return [
            [
                [
                    'isActualAddress',
                    'POST_INDEX',
                    'POST_PROVINCE',
                    'POST_REGION',
                    'POST_STREET_TYPE',
                    'POST_STREET',
                    'POST_HOUSE'
                ], 'required'],
            [
                'POST_CITY_TYPE', 'required', 'when' => function ($model) {
                return !empty($model->POST_CITY_NM);
            }, 'whenClient' => 'function() {return false}'],
            [
                'POST_SETTLEMENT_TYPE', 'required', 'when' => function ($model) {
                return !empty($model->POST_SETTLEMENT_NM);
            }, 'whenClient' => 'function() {return false}'],
            [
                [
                    'POST_PROVINCE',
                    'POST_REGION',
                    'POST_CITY_TYPE',
                    'POST_CITY_NM',
                    'POST_SETTLEMENT_TYPE',
                    'POST_SETTLEMENT_NM',
                    'POST_STREET_TYPE',
                    'POST_STREET',
                ], 'match', 'pattern' => '/[^a-zA-Z_-]/', 'message' => 'Допускаются только символы кириллицы'],
            [
                [
                    'POST_HOUSE',
                    'POST_CLUSTER',
                    'POST_FLAT'
                ], 'string', 'max' => 20],
            ['POST_INDEX', 'match', 'pattern' => '/^\d{6}$/', 'message' => 'Индекс должен состоять из 6-ти цифр'],
            ['POST_INDEX', 'string', 'max' => 6],
            [
                [
                    'POST_PROVINCE',
                    'POST_REGION',
                    'POST_CITY_TYPE',
                    'POST_CITY_NM',
                    'POST_SETTLEMENT_TYPE',
                    'POST_SETTLEMENT_NM',
                    'POST_STREET_TYPE',
                    'POST_STREET'
                ], 'string', 'max' => 100],
            [
                [
                    'POST_CITY_NM', 'POST_SETTLEMENT_NM'
                ], 'validateCityAndSettlement'],
            [
                [
                    'POST_CITY_TYPE', 'POST_SETTLEMENT_TYPE'
                ], 'validateTypes']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'isActualAddress' => 'Адрес актуален?',
            'POST_INDEX' => 'Индекс',
            'POST_PROVINCE' => 'Область',
            'POST_REGION' => 'Район',
            'POST_CITY_TYPE' => 'Город сокращенно',
            'POST_CITY_NM' => 'Город',
            'POST_SETTLEMENT_TYPE' => 'Населенный пункт сокращенно',
            'POST_SETTLEMENT_NM' => 'Населенный пункт',
            'POST_STREET_TYPE' => 'Улица сокращенно',
            'POST_STREET' => 'Улица',
            'POST_HOUSE' => 'Дом',
            'POST_CLUSTER' => 'Корпус/строение',
            'POST_FLAT' => 'Квартира'
        ];
    }

    public function validateCityAndSettlement($attribute)
    {
        if ($this->POST_CITY_NM && $this->POST_SETTLEMENT_NM) {
            $this->addError($attribute, self::ERROR_MESSAGE);
        } elseif (empty($this->POST_CITY_NM) && empty($this->POST_SETTLEMENT_NM)) {
            $this->addError($attribute, self::ERROR_MESSAGE);
        }
    }

    public function validateTypes($attribute)
    {
        if ($this->POST_CITY_TYPE && $this->POST_SETTLEMENT_TYPE) {
            $this->addError($attribute, self::ERROR_MESSAGE);
        }
    }

    public function getActualAddressOptions()
    {
        return self::ACTUAL_ADDRESS_OPTIONS;
    }

    public function isActualAddress()
    {
        return 1 === (int) $this->isActualAddress;
    }
}