<?php

namespace app\modules\cardWithDelivery\models;

use newcontact\corein\models\Calls;
use newcontact\corein\models\CallsResults;
use newcontact\corein\models\CallsStatusesHistory;

class CallStatusesHistory extends CallsStatusesHistory
{
    public function setCall(Calls $call)
    {
        $this->FID_CALL = $call->getPrimaryKey();
    }

    public function setStatus(CallsResults $status)
    {
        $this->FID_STATUS = $status->getPrimaryKey();
    }

}