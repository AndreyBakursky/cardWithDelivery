<?php

namespace app\modules\cardWithDelivery\interfaces;

use newcontact\corein\models\CallsResults;

interface StatusInstaller
{
    public function statusUpdate(CallsResults $callStatus);
}