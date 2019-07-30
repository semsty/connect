<?php

namespace connect\crm\retailcrm\filter;

use connect\crm\base\helpers\ArrayHelper;
use connect\crm\retailcrm\filter\base\Filter;
use connect\crm\retailcrm\filter\base\TransactionFilterTrait;

class Orders extends Filter
{
    use TransactionFilterTrait;

    public $numbers = [];
    public $customer;
    public $customerId;
    public $customerExternalId;
    public $countries = [];
    public $index;
    public $metro;
    public $deliveryTimeFrom;
    public $deliveryTimeTo;
    public $minPrepaySumm;
    public $maxPrepaySumm;
    public $minPrice;
    public $maxPrice;
    public $product;
    public $expired;
    public $call;
    public $minDeliveryCost;
    public $maxDeliveryCost;
    public $minDeliveryNetCost;
    public $maxDeliveryNetCost;
    public $managerComment;
    public $customerComment;
    public $minMarginSumm;
    public $maxMarginSumm;
    public $minPurchaseSumm;
    public $maxPurchaseSumm;
    public $trackNumber;
    public $shipped;
    public $uploadedToExtStoreSys;
    public $receiptFiscalDocumentAttribute;
    public $receiptStatus;
    public $receiptOperation;
    public $orderTypes = [];
    public $paymentStatuses = [];
    public $paymentTypes = [];
    public $deliveryTypes = [];
    public $orderMethods = [];
    public $couriers = [];
    public $shipmentStores = [];
    public $createdAtFrom;
    public $createdAtTo;
    public $fullPaidAtFrom;
    public $fullPaidAtTo;
    public $deliveryDateFrom;
    public $deliveryDateTo;
    public $statusUpdatedAtFrom;
    public $statusUpdatedAtTo;
    public $dpdParcelDateFrom;
    public $dpdParcelDateTo;
    public $shipmentDateFrom;
    public $shipmentDateTo;
    public $extendedStatus = [];

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), static::subRules(), [
            [
                [
                    'customer', 'customerId', 'customerExternalId', 'index', 'metro', 'minPrice', 'maxPrice',
                    'product', 'minDeliveryCost', 'maxDeliveryCost', 'minDeliveryNetCost', 'maxDeliveryNetCost',
                    'managerComment', 'customerComment', 'minMarginSumm', 'maxMarginSumm', 'minPurchaseSumm',
                    'maxPurchaseSumm', 'trackNumber', 'receiptFiscalDocumentAttribute'
                ], 'string'
            ],
            [['numbers'], 'each', 'rule' => ['string']],
            ['countries', 'in', 'range' => ['BY', 'KZ', 'RU', 'UA']],
            [['deliveryTimeFrom', 'deliveryTimeTo'], 'time', 'format' => 'php:H:i:s'],
            [['expired', 'call', 'shipped', 'uploadedToExtStoreSys',], 'in', 'range' => [0, 1]],
            ['receiptStatus', 'in', 'range' => ['done', 'fail', 'wait']],
            ['receiptOperation', 'in', 'range' => ['sell', 'sell_refund']],
            [
                [
                    'orderTypes', 'paymentStatuses', 'paymentTypes', 'deliveryTypes', 'orderMethods',
                    'couriers', 'shipmentStores', 'extendedStatus'
                ], 'each', 'rule' => ['string']
            ],
            [
                [
                    'fullPaidAtFrom', 'fullPaidAtTo', 'deliveryDateFrom',
                    'deliveryDateTo', 'statusUpdatedAtFrom', 'statusUpdatedAtTo', 'dpdParcelDateFrom',
                    'dpdParcelDateTo', 'shipmentDateFrom', 'shipmentDateTo'
                ], 'date', 'format' => 'php:Y-m-d'
            ],
            [
                [
                    'createdAtFrom', 'createdAtTo',
                ], 'date', 'format' => 'php:Y-m-d H:i:s'
            ]
        ]);
    }
}
