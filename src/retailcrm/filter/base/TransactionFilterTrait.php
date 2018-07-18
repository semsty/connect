<?php

namespace connect\crm\retailcrm\filter\base;

/**
 * Trait TransactionFilterTrait
 */
trait TransactionFilterTrait
{
    /**
     * @var array $externalIds
     */
    public $externalIds = [];

    /**
     * @var array $customFields
     */
    public $customFields = [];

    /**
     * @var $source
     */
    public $source;

    /**
     * @var $medium
     */
    public $medium;

    /**
     * @var $campaign
     */
    public $campaign;

    /**
     * @var $keyword
     */
    public $keyword;

    /**
     * @var $content
     */
    public $content;

    /**
     * @var $city
     */
    public $city;

    /**
     * @var $region
     */
    public $region;

    /**
     * @var $name
     */
    public $name;

    /**
     * @var $email
     */
    public $email;

    /**
     * @var array $ids
     */
    public $ids = [];

    /**
     * @var array $sites
     */
    public $sites = [];

    /**
     * @var array $managers
     */
    public $managers = [];

    /**
     * @var $firstWebVisitFrom
     */
    public $firstWebVisitFrom;

    /**
     * @var $firstWebVisitTo
     */
    public $firstWebVisitTo;

    /**
     * @var $lastWebVisitFrom
     */
    public $lastWebVisitFrom;

    /**
     * @var $lastWebVisitTo
     */
    public $lastWebVisitTo;

    /**
     * @var $firstOrderFrom
     */
    public $firstOrderFrom;

    /**
     * @var $firstOrderTo
     */
    public $firstOrderTo;

    /**
     * @var $lastOrderFrom
     */
    public $lastOrderFrom;

    /**
     * @var $lastOrderTo
     */
    public $lastOrderTo;

    /**
     * @var array $managerGroups
     */
    public $managerGroups = [];

    /**
     * @var $attachments
     */
    public $attachments;

    /**
     * @var $contragentName
     */
    public $contragentName;

    /**
     * @var array $contragentTypes
     */
    public $contragentTypes = [];

    /**
     * @var $contragentInn
     */
    public $contragentInn;

    /**
     * @var $contragentKpp
     */
    public $contragentKpp;

    /**
     * @var $contragentBik
     */
    public $contragentBik;

    /**
     * @var $contragentCorrAccount
     */
    public $contragentCorrAccount;

    /**
     * @var $contragentBankAccount
     */
    public $contragentBankAccount;

    /**
     * @var $vip
     */
    public $vip;

    /**
     * @var $bad
     */
    public $bad;

    /**
     * @var $minCostSumm
     */
    public $minCostSumm;

    /**
     * @var $maxCostSumm
     */
    public $maxCostSumm;

    /**
     * @var $online
     */
    public $online;

    /**
     * @return array
     */
    public static function subRules(): array
    {
        return [
            [
                [
                    'source', 'medium', 'campaign', 'keyword', 'content',
                    'city', 'region', 'name', 'email', 'contragentName', 'contragentInn', 'contragentKpp',
                    'contragentBik', 'contragentCorrAccount', 'contragentBankAccount', 'minCostSumm',
                    'maxCostSumm', 'vip', 'bad', 'online'
                ], 'string', 'length' => [0, 255]
            ],
            ['ids', 'each', 'rule' => ['integer']],
            ['externalIds', 'each', 'rule' => ['string']],
            [['sites', 'managers', 'managerGroups', 'contragentTypes', 'externalIds'], 'each', 'rule' => ['string']],
            [
                [
                    'firstWebVisitFrom', 'firstWebVisitTo', 'lastWebVisitFrom', 'lastWebVisitTo',
                    'firstOrderFrom', 'firstOrderTo', 'lastOrderFrom', 'lastOrderTo'
                ], 'date', 'format' => 'php:Y-m-d'
            ],
            [['attachments'], 'in', 'range' => [1, 2, 3]],
            [['vip', 'bad', 'online'], 'in', 'range' => [0, 1]]

        ];
    }
}
