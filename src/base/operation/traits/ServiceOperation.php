<?php

namespace connect\crm\base\operation\traits;

use connect\crm\base\Action;
use connect\crm\base\traits\ProfiledModel;
use connect\crm\base\traits\ServiceModel;

trait ServiceOperation
{
    use ProfiledModel, ServiceModel;

    public function getName(): string
    {
        return $this->service->getName() . '.' . static::NAME;
    }

    public function getAction($className, $auth = false): Action
    {
        $action = $this->service->action($className::ID);
        if (property_exists($className, 'with_auth')) {
            $action->with_auth = $auth;
        }
        return $action;
    }
}
