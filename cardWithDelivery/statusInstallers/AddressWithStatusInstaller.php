<?php

namespace app\modules\cardWithDelivery\statusInstallers;

use app\modules\cardWithDelivery\models\ContactsParams;
use newcontact\corein\models\CallsResults;
use yii\db\Exception;

class AddressWithStatusInstaller extends CallStatusInstaller
{
    /**
     * $contactAddress
     */
    protected $contactAddress;

    public function statusUpdate(CallsResults $callStatus)
    {
        $transaction = $this->connection->beginTransaction();
        try {
            $this->assignNewAddress();
            $this->callStatus($callStatus);
            $this->contactStatus($callStatus);
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    protected function assignNewAddress()
    {
        foreach ($this->contactAddress->attributes as $param => $value) {
            $newAddress = new ContactsParams();
            $newAddress->setAttributes(
                [
                    'PARAM_NAME' => $param,
                    'PARAM_VALUE' => $value
                ]
            );
            $newAddress->save(false);
        }
    }
}