<?php

namespace app\modules\cardWithDelivery\statusInstallers;

use app\models\Calls;
use app\modules\cardWithDelivery\interfaces\StatusInstaller;
use app\modules\cardWithDelivery\models\Delivery;
use newcontact\corein\models\CallsResults;
use yii\db\Connection;
use yii\db\Exception;

class CallStatusInstaller implements StatusInstaller
{
    /**
     * $call
     */
    protected $call;

    /**
     * $connection
     */
    protected $connection;

    public function __construct(Calls $call, Connection $connection, Delivery $contactAddress = null)
    {
        $this->call = $call;
        $this->connection = $connection;
        $this->contactAddress = $contactAddress;
    }

    public function statusUpdate(CallsResults $callStatus)
    {
        $transaction = $this->connection->beginTransaction();
        try {
            $this->callStatus($callStatus);
            $this->contactStatus($callStatus);
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    protected function callStatus(CallsResults $callStatus)
    {
        $this->call->finish($callStatus);
        $this->call->save(false);
    }

    protected function contactStatus(CallsResults $callStatus)
    {
        $contact = $this->call->contact;
        $contact->finish($this->call, $callStatus);
        $contact->save(false);
    }
}