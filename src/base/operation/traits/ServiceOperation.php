<?php

namespace semsty\connect\base\operation\traits;

use semsty\connect\base\Action;
use semsty\connect\base\traits\ProfiledModel;
use semsty\connect\base\traits\ServiceModel;

trait ServiceOperation
{
    use ProfiledModel, ServiceModel;

    public function getName(): string
    {
        return $this->service->getName() . '.' . static::NAME;
    }

    public function getAction($className, $auth = false): Action
    {
        $action = $this->service->action($className::ACTION_ID);
        if (property_exists($className, 'with_auth')) {
            $action->with_auth = $auth;
        }
        return $action;
    }
}
