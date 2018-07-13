<?php

namespace semsty\connect\retailcrm;

use semsty\connect\base\dict\Action;
use semsty\connect\base\Service as BaseService;
use semsty\connect\retailcrm\action\lists\Credentials;
use semsty\connect\retailcrm\action\lists\Customers;
use semsty\connect\retailcrm\action\lists\CustomFields;
use semsty\connect\retailcrm\action\lists\Dictionaries;
use semsty\connect\retailcrm\action\lists\History;
use semsty\connect\retailcrm\action\lists\Notes;
use semsty\connect\retailcrm\action\lists\Orders;
use semsty\connect\retailcrm\action\lists\Statuses;
use semsty\connect\retailcrm\action\set\CustomerCreate;
use semsty\connect\retailcrm\action\set\CustomerEdit;
use semsty\connect\retailcrm\action\set\NoteCreate;
use semsty\connect\retailcrm\action\set\OrderCreate;
use semsty\connect\retailcrm\action\set\OrderEdit;
use semsty\connect\retailcrm\dict\Data;
use semsty\connect\retailcrm\dict\Entities;
use semsty\connect\retailcrm\dict\Fields;
use semsty\connect\retailcrm\query\Query;
use yii\helpers\ArrayHelper;

class Service extends BaseService
{
    const SERVICE_ID = 2;
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
