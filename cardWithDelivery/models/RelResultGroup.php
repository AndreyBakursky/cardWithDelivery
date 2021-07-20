<?php

namespace app\modules\cardWithDelivery\models;

use newcontact\corein\models\CallsResultsGroupsResults;

class RelResultGroup extends CallsResultsGroupsResults
{
    public function getGroup()
    {
        return $this->hasOne(ResultGroup::class, ['ID_GROUP' => 'FID_GROUP']);
    }
}