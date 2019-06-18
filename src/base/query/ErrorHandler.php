<?php

namespace connect\crm\base\query;

use yii\base\Model;

class ErrorHandler extends Model
{
    /**
     * @var $connection Connection
     */
    public $connection;

    /**
     * @param $error
     * @param array $context
     * @return array
     */
    public function handle($error, $context = [])
    {

    }
}