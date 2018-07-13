<?php

namespace semsty\connect\retailcrm\filter;

use semsty\connect\base\helpers\ArrayHelper;
use semsty\connect\retailcrm\filter\base\Filter;

/**
 * Class HistoryFilter
 * @package semsty\connect\retailcrm\filter
 */
class HistoryFilter extends Filter
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
