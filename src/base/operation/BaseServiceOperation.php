<?php

namespace connect\crm\base\operation;

use connect\crm\base\helpers\ArrayHelper;
use connect\crm\base\operation\traits\ServiceOperation as ServiceOperationTrait;
use connect\crm\base\Profile;
use connect\crm\base\Service;
use connect\crm\base\traits\ReferenceReflection;

/**
 * Class ServiceOperation
 * @property $service
 * @property $profile
 * @package connect\crm\base\operation
 */
class BaseServiceOperation extends Operation
{
    use ServiceOperationTrait, ReferenceReflection;

    const TYPE = 'service-operation';
    const NAME = 'service-operation';
    const GROUP = 'base';

    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->getService();
        if (empty($this->service->_profile) && $this->_profile) {
            $this->service->profile = $this->profile;
        }
    }

    public static function getProfileClass()
    {
        return static::getReferenceClass('Profile', Profile::class, 1);
    }

    public function rules(): array
    {
        return ArrayHelper::merge(parent::rules(), [
            [['service', 'profile'], 'safe']
        ]);
    }

    public function run()
    {
        return true;
    }

    public function getEventName($name): string
    {
        $operation_name = $this->getName();
        return parent::getEventName("$operation_name.$name");
    }

    public function getTypeName(): string
    {
        $name = parent::getTypeName();
        $service_class = static::getServiceClass();
        $service_name = $service_class::NAME;
        return "$service_name.$name";
    }

    public static function getServiceClass()
    {
        return static::getReferenceClass('Service', Service::class, 1);
    }
}
