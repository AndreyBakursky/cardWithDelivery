<?php

namespace app\modules\cardWithDelivery\interfaces;

use app\models\ContactParams;

interface ParamInstaller
{
    public function paramsInstall(ContactParams $contactParams);
}