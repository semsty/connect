<?php

namespace connect\crm\retailcrm\filter;

use connect\crm\base\helpers\ArrayHelper;
use connect\crm\retailcrm\filter\base\Filter;

/**
 * Class HistoryFilter
 * @package connect\crm\retailcrm\filter
 */
class History extends Filter
{
    /**
     * @var $orderId
     */
    public $orderId;

    /**
     * @var $sinceId
     */
    public $sinceId;

    /**
     * @var $orderExternalId
     */
    public $orderExternalId;

    /**
     * @var $startDate
     */
    public $startDate;

    /**
     * @var $endDate
     */
    public $endDate;

    /**
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['orderExternalId'], 'string'],
            [['orderId', 'sinceId'], 'integer'],
            [['startDate', 'endDate'], 'date', 'format' => 'php:Y-m-d H:i:s']
        ]);
    }
}
