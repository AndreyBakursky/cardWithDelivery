<?php

namespace app\modules\cardWithDelivery\models;

use Exception;
use DateTime;
use DateTimeZone;
use yii\base\Model;

class Callback extends Model
{
    public const REASONS = [
        'Перезвонить позже' => 'Перезвонить позже',
        'Перезвонить по другому номеру' => 'Перезвонить по другому номеру'
    ];

    /**
     * Комментарий оператора
     * @var $comment
     */
    public $comment;

    /**
     * Дата и время перезвона
     * @var $dateTime
     */
    public $dateTime;

    /**
     * Мобильный номер
     * @var $phoneNumber
     */
    public $phoneNumber;

    /**
     * Причина перезвона
     * @var $reason
     */
    public $reason;

    /**
     * Таймзона клиента
     * @var $clientTimeZone
     */
    public $clientTimeZone;

    public function rules()
    {
        return [
            [['dateTime', 'reason'], 'required'],
            ['dateTime', 'validateDateTime'],
            ['phoneNumber', 'match', 'pattern' => '/^\d{10}$/', 'message' => 'Введите 10-ти значный номер (без +7 и 8)'],
            ['comment', 'string', 'max' => 255],
            ['comment', 'match', 'pattern' => '/[^a-zA-Z_-]/', 'message' => 'Допускаются только символы кириллицы']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'comment' => 'Комментарий оператора',
            'dateTime' => 'Дата перезвона',
            'phoneNumber' => 'Мобильный телефон',
            'reason' => 'Причина перезвона'
        ];
    }

    /**
     * @return array
     */
    public function getReasonCallback()
    {
        return self::REASONS;
    }

    public function getReason()
    {
        return $this->reason;
    }

    public function getDateTime()
    {
        return $this->dateTime;
    }

    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Проверка правильности указанного времени
     */
    public function validateDateTime($attribute)
    {
        try {
            $clientCurrentTime = new DateTime('now', new DateTimeZone('Europe/Moscow'));
            $clientCurrentTime->modify("+ $this->clientTimeZone HOURS");

            $clientIndicateTime = new DateTime($this->$attribute, new DateTimeZone('Europe/Moscow'));

            if ($clientIndicateTime < $clientCurrentTime) {
                $this->addError($attribute, 'Время перезвона меньше текущего времени клиента');
            }
        } catch (Exception $ex) {
            $this->addError($attribute, 'Указан неверный формат даты');
        }
    }
}