<?php

namespace app\modules\cardWithDelivery\models;

use DateTime;
use DateTimeZone;
use yii\base\Model;
use Exception;

class OfferParams extends Model
{
    /**
     * Лимит предложения для клиента
     * @var $OFFER_LIMIT
     */
    public $OFFER_LIMIT;

    /**
     * Срок действия предложения
     * @var $OFFER_TERM
     */
    public $OFFER_TERM;

    /**
     * Id оффиса, сделавшего предложение
     * @var $OFFER_OFFICE_ID
     */
    public $OFFER_OFFICE_ID;

    /**
     * Id оффиса посещения
     * @var $NEW_VISIT_OFFICE
     */
    public $NEW_VISIT_OFFICE;

    /**
     * Время действия предложения
     * @var $OFFER_VALID_TO
     */
    public $OFFER_VALID_TO;

    /**
     * Сумма оплаты
     * @var $PAYMENT
     */
    public $PAYMENT;

    /**
     * Время обращения в отделение
     * @var $AGREE_VISIT_DATE_
     */
    public $AGREE_VISIT_DATE;

    /**
     * @var mixed
     */
    public function rules()
    {
        return [
            [
                [
                    'OFFER_LIMIT',
                    'OFFER_TERM',
                    'NEW_VISIT_OFFICE',
                    'OFFER_VALID_TO',
                    'PAYMENT',
                ], 'safe'
            ],
            [
                [
                    'OFFER_OFFICE_ID',
                    'AGREE_VISIT_DATE'
                ], 'required'],
            [['AGREE_VISIT_DATE', 'OFFER_OFFICE_ID'], 'checkDateTime']
        ];
    }

    public function attributeLabels()
    {
        return [
            'OFFER_LIMIT' => 'Лимит предложения для клиента',
            'OFFER_TERM' => 'Срок действия предложения',
            'OFFER_OFFICE_ID' => 'Id оффиса, сделавшего предложение',
            'NEW_VISIT_OFFICE' => 'Id оффиса посещения',
            'OFFER_VALID_TO' => 'Время действия предложения',
            'PAYMENT' => 'Сумма оплаты',
            'AGREE_VISIT_DATE' => 'Время обращения в отделение'
        ];
    }

    public function checkDateTime($attribute1, $attribute2)
    {
        try {

            if (empty($attribute2)) {
                $this->addError($attribute1, 'Укажите нужный ККО для визита клиента из списка выше');
            }

            $currentTime = new DateTime('now', new DateTimeZone('Europe/Moscow'));

            $clientOfferTime = new DateTime($this->OFFER_VALID_TO, new DateTimeZone('Europe/Moscow'));

            $clientIndicateTime = new DateTime($this->$attribute1, new DateTimeZone('Europe/Moscow'));

            if ($clientIndicateTime > $clientOfferTime) {
                $this->addError($attribute1, 'На указанное время истечет предложение для клиента');
            }

            if ($clientIndicateTime <= $currentTime) {
                $this->addError($attribute1, 'Указанное время должно быть не ранее, чем сегодня');
            }

            if ($clientIndicateTime > $currentTime->modify("+ 13 DAYS")) {
                $this->addError($attribute1, 'Указанное время должно быть не более 14 дней, начиная с момента звонка');
            }
        } catch (Exception $ex) {
            $this->addError($attribute1, 'Указан неверный формат даты');
        }
    }

//    public function checkOfferOfficeId($attribute)
//    {
//        if (empty($this->OFFER_OFFICE_ID)) {
//            $this->addError($attribute, 'Укажите нужный ККО для визита клиента из списка выше');
//        }
//    }

    /**
     * @throws Exception
     */
    public function dateOfferValidTo(): string
    {
        $dateOffer = new DateTime($this->OFFER_VALID_TO, new DateTimeZone('Europe/Moscow'));
        return $dateOffer->format("d.m.Y");
    }

    public function getOfferLimit()
    {
        return $this->OFFER_LIMIT;
    }

    public function getOfferTerm()
    {
        return $this->OFFER_TERM;
    }

    public function getPayment()
    {
        return $this->PAYMENT;
    }

    public function getOfferOfficeId()
    {
        return $this->OFFER_OFFICE_ID;
    }

    public function getAgreeVisitDate()
    {
        return $this->AGREE_VISIT_DATE;
    }

    public function getNewVisitOffice()
    {
        return $this->NEW_VISIT_OFFICE;
    }
}