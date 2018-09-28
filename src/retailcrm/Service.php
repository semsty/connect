<?php

namespace connect\crm\retailcrm;

use connect\crm\base\dict\Action;
use connect\crm\base\Service as BaseService;
use connect\crm\retailcrm\action\lists\Credentials;
use connect\crm\retailcrm\action\lists\Customers;
use connect\crm\retailcrm\action\lists\CustomFields;
use connect\crm\retailcrm\action\lists\Dictionaries;
use connect\crm\retailcrm\action\lists\History;
use connect\crm\retailcrm\action\lists\Notes;
use connect\crm\retailcrm\action\lists\Orders;
use connect\crm\retailcrm\action\lists\Statuses;
use connect\crm\retailcrm\action\lists\Users;
use connect\crm\retailcrm\action\set\Calls;
use connect\crm\retailcrm\action\set\CustomerCreate;
use connect\crm\retailcrm\action\set\CustomerEdit;
use connect\crm\retailcrm\action\set\NoteCreate;
use connect\crm\retailcrm\action\set\OrderCreate;
use connect\crm\retailcrm\action\set\OrderEdit;
use connect\crm\retailcrm\dict\Data;
use connect\crm\retailcrm\dict\Entities;
use connect\crm\retailcrm\dict\Fields;
use connect\crm\retailcrm\query\Query;
use yii\helpers\ArrayHelper;

/**
 * Class Service
 * @link https://www.retailcrm.ru/docs/Developers/Index
 * @package connect\crm\retailcrm
 */
class Service extends BaseService
{
    const ID = 2;
    const NAME = 'retailcrm';

    public $url = 'https://{subdomain}.retailcrm.ru';
    public $formats = ['json', 'x-www-form-urlencoded'];

    public static function getDictionariesList(): array
    {
        return ArrayHelper::merge(parent::getDictionariesList(), [
            Data::class,
            Entities::class,
            Fields::class
        ]);
    }

    public static function getDataProviderActions(): array
    {
        return [
            Action::INFO => Dictionaries::class,
            Entities::STATUS => [
                Action::LIST => Statuses::class
            ],
            Entities::CREDENTIAL => [
                Action::LIST => Credentials::class
            ],
            Entities::CUSTOM_FIELD => [
                Action::LIST => CustomFields::class
            ],
            Entities::CUSTOM_DICTIONARY => [
                Action::LIST => Dictionaries::class
            ],
            Entities::ORDER => [
                Action::LIST => Orders::class
            ],
            Entities::CUSTOMER => [
                Action::LIST => Customers::class
            ],
            Entities::HISTORY => [
                Action::LIST => History::class
            ],
            Entities::NOTE => [
                Action::LIST => Notes::class
            ],
            Entities::USER => [
                Action::LIST => Users::class
            ]
        ];
    }

    public static function getDataRecipientActions(): array
    {
        return [
            Entities::CUSTOMER => [
                Action::CREATE => CustomerCreate::class,
                Action::UPDATE => CustomerEdit::class,
            ],
            Entities::ORDER => [
                Action::CREATE => OrderCreate::class,
                Action::UPDATE => OrderEdit::class
            ],
            Entities::NOTE => [
                Action::CREATE => NoteCreate::class
            ],
            Entities::CALL => [
                Action::CREATE => Calls::class
            ]
        ];
    }

    public function getConfig(): array
    {
        return ArrayHelper::merge(parent::getConfig(), [
            'requestConfig' => [
                'options' => [
                    'referer' => ArrayHelper::getValue($_SERVER, 'HTTP_HOST')
                ],
                'class' => Query::class
            ]
        ]);
    }
}
