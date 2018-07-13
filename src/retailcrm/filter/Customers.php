<?php

namespace semsty\connect\retailcrm\filter;

use semsty\connect\base\helpers\ArrayHelper;
use semsty\connect\retailcrm\filter\base\Filter;
use semsty\connect\retailcrm\filter\base\TransactionFilterTrait;

/**
 * Class CustomersFilter
 */
class Customers extends Filter
{
    use TransactionFilterTrait;

    /**
     * @var $notes
     */
    public $notes;

    /**
     * @var $minOrdersCount
     */
    public $minOrdersCount;

    /**
     * @var $maxOrdersCount
     */
    public $maxOrdersCount;

    /**
     * @var $minAverageSumm
     */
    public $minAverageSumm;

    /**
     * @var $maxAverageSumm
     */
    public $maxAverageSumm;

    /**
     * @var $minTotalSumm
     */
    public $minTotalSumm;

    /**
     * @var $maxTotalSumm
     */
    public $maxTotalSumm;

    /**
     * @var $classSegment
     */
    public $classSegment;

    /**
     * @var $sex
     */
    public $sex;

    /**
     * @var $discountCardNumber
     */
    public $discountCardNumber;

    /**
     * @var $emailMarketingUnsubscribed
     */
    public $emailMarketingUnsubscribed;

    /**
     * @var $segment
     */
    public $segment;

    /**
     * @var $dateFrom
     */
    public $dateFrom;

    /**
     * @var $dateTo
     */
    public $dateTo;

    /**
     * @var $browserId
     */
    public $browserId;

    /**
     * @var $commentary
     */
    public $commentary;

    /**
     * @var $lastName
     */
    public $lastName;

    /**
     * @var $firstName
     */
    public $firstName;

    /**
     * @var $phones
     */
    public $phone;

    public static function map(): array
    {
        return ArrayHelper::merge(parent::map(), [
            'firstName' => 'name',
            'lastName' => 'name',
            'phone' => 'name'
        ]);
    }

    /**
     * {{inheritdoc}}
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), static::subRules(), [
            [
                [
                    'notes', 'minOrdersCount', 'maxOrdersCount', 'minAverageSumm', 'maxAverageSumm', 'minTotalSumm',
                    'maxTotalSumm', 'classSegment', 'sex', 'discountCardNumber', 'emailMarketingUnsubscribed',
                    'segment', 'browserId', 'commentary', 'lastName', 'firstName', 'phone'
                ], 'string'
            ],
            [['sex'], 'in', 'range' => ['male', 'female']],
            [['emailMarketingUnsubscribed'], 'in', 'range' => [0, 1]],
            [['dateFrom', 'dateTo'], 'date', 'format' => 'php:Y-m-d']
        ]);
    }
}
