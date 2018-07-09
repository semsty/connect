<?php

namespace semsty\connect\base\traits;

use semsty\connect\base\Session;

trait SessionModel
{
    /**
     * @var $_session Session
     */
    protected $_session;

    public function getSession(): Session
    {
        if (empty($this->_session)) {
            $className = static::getSessionClass();
            $attributes = $this->getSessionAttributes();
            $this->_session = new $className($attributes);
        }
        return $this->_session;
    }

    /**
     * @param $session Session
     */
    public function setSession(&$session)
    {
        $this->_session = $session;
    }

    public function getSessionAttributes(): array
    {
        return [];
    }
}
