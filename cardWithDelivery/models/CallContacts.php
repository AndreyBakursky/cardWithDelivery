<?php

namespace app\modules\cardWithDelivery\models;

use app\models\Contacts;

class CallContacts extends Contacts
{
    public function getCallPhones()
    {
        return $this->hasMany(CallPhones::class, ['FID_CONTACT' => 'ID_CONTACT']);
    }
}