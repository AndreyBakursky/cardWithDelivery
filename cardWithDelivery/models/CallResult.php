<?php

namespace app\modules\cardWithDelivery\models;

use newcontact\corein\models\CallsResults;

class CallResult extends CallsResults
{
    public function getRelResultGroup()
    {
        return $this->hasOne(RelResultGroup::class, ['FID_RESULT' => 'ID_RESULT']);
    }

    public function getCallResultName()
    {
        return $this->CALL_RESULT_NAME;
    }

    public function getIdResult()
    {
        return $this->ID_RESULT;
    }
}