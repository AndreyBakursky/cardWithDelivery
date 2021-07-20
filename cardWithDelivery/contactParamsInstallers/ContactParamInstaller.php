<?php

namespace app\modules\cardWithDelivery\contactParamsInstallers;

use app\models\ContactParams;
use app\modules\cardWithDelivery\interfaces\ParamInstaller;
use yii\db\Connection;
use yii\db\Exception;

class ContactParamInstaller implements ParamInstaller
{
    /**
     * $connection
     */
    protected $connection;

    /**
     * $paramName
     */
    protected $paramName;

    /**
     * $contactAddress
     */
    protected $paramValue;

    public function __construct(Connection $connection, $paramName , $paramValue)
    {
        $this->connection = $connection;
        $this->paramName = $paramName;
        $this->paramValue = $paramValue;
    }

    public function paramsInstall(ContactParams $contactParams)
    {
        $transaction = $this->connection->beginTransaction();
        try {
            $this->paramNameInstall($contactParams);
            $this->paramValueInstall($contactParams);
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    protected function paramNameInstall(ContactParams $contactParams)
    {
        $contactParams->setParamName($this->paramName);
        $contactParams->save(false);
    }

    protected function paramValueInstall(ContactParams $contactParams)
    {
        $contactParams->setParamValue($this->paramValue);
        $contactParams->save(false);
    }
}