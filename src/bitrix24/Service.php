<?php

namespace semsty\connect\bitrix24;

use semsty\connect\base\dict\Action;
use semsty\connect\base\Service as BaseService;
use semsty\connect\bitrix24\actions\Add;
use semsty\connect\bitrix24\actions\Auth;
use semsty\connect\bitrix24\actions\DealContactAdd;
use semsty\connect\bitrix24\actions\Delete;
use semsty\connect\bitrix24\actions\Fields;
use semsty\connect\bitrix24\actions\Get;
use semsty\connect\bitrix24\actions\ListAction;
use semsty\connect\bitrix24\actions\Update;
use semsty\connect\bitrix24\actions\UserFieldAdd;
use semsty\connect\bitrix24\actions\UserFieldDelete;
use semsty\connect\bitrix24\actions\UserFieldGet;
use semsty\connect\bitrix24\actions\UserFieldList;
use semsty\connect\bitrix24\actions\UserFieldUpdate;
use semsty\connect\bitrix24\dict\Data;
use semsty\connect\bitrix24\dict\Entities;
use semsty\connect\bitrix24\dict\Fields as FieldsDictionary;
use semsty\connect\bitrix24\dict\Selects;
use semsty\connect\bitrix24\dict\Types;
use semsty\connect\bitrix24\operations\CheckLeads;
use semsty\connect\bitrix24\operations\GetChanges;
use semsty\connect\bitrix24\operations\GetLeads;
use semsty\connect\bitrix24\operations\ProxyOperation;
use semsty\connect\bitrix24\operations\StatFullUpdate;
use semsty\connect\bitrix24\query\Query;
use yii\helpers\ArrayHelper;

class Service extends BaseService
{
    const ID = 5;
    const NAME = 'bitrix24';

    const CLOUD_DOMAIN = 'bitrix24.ru';

    public $url = 'https://{domain}/';
    public $formats = ['json'];

    public static function getDictionariesList(): array
    {
        return ArrayHelper::merge(parent::getDictionariesList(), [
            Data::class,
            Entities::class,
            Selects::class,
            FieldsDictionary::class,
            Types::class
        ]);
    }

    public static function getDataProviderActions(): array
    {
        return [
            Action::AUTH => Auth::class,
            Action::INFO => Fields::class,
            Entities::LEAD => [
                Action::GET => [Get::class, ['entity' => Entities::LEAD]],
                Action::LIST => [ListAction::class, ['entity' => Entities::LEAD]],
            ],
            Entities::DEAL => [
                Action::GET => [Get::class, ['entity' => Entities::DEAL]],
                Action::LIST => [ListAction::class, ['entity' => Entities::DEAL]],
            ],
            Entities::COMPANY => [
                Action::GET => [Get::class, ['entity' => Entities::COMPANY]],
                Action::LIST => [ListAction::class, ['entity' => Entities::COMPANY]],
            ],
            Entities::CONTACT => [
                Action::GET => [Get::class, ['entity' => Entities::CONTACT]],
                Action::LIST => [ListAction::class, ['entity' => Entities::CONTACT]],
            ],
            Entities::CUSTOM_FIELD => [
                Action::GET => UserFieldGet::class,
                Action::LIST => UserFieldList::class
            ]
        ];
    }

    public static function getDataRecipientActions(): array
    {
        return [
            Entities::LEAD => [
                Action::CREATE => [Add::class, ['entity' => Entities::LEAD]],
                Action::UPDATE => [Update::class, ['entity' => Entities::LEAD]],
                Action::DELETE => [Delete::class, ['entity' => Entities::LEAD]],
            ],
            Entities::DEAL => [
                Action::CREATE => [Add::class, ['entity' => Entities::DEAL]],
                Action::UPDATE => [Update::class, ['entity' => Entities::DEAL]],
                Action::DELETE => [Delete::class, ['entity' => Entities::DEAL]],
            ],
            Entities::COMPANY => [
                Action::CREATE => [Add::class, ['entity' => Entities::COMPANY]],
                Action::UPDATE => [Update::class, ['entity' => Entities::COMPANY]],
                Action::DELETE => [Delete::class, ['entity' => Entities::COMPANY]],
            ],
            Entities::CONTACT => [
                Action::CREATE => [Add::class, ['entity' => Entities::CONTACT]],
                Action::UPDATE => [Update::class, ['entity' => Entities::CONTACT]],
                Action::DELETE => [Delete::class, ['entity' => Entities::CONTACT]],
            ],
            Entities::CUSTOM_FIELD => [
                Action::CREATE => UserFieldAdd::class,
                Action::UPDATE => UserFieldUpdate::class,
                Action::DELETE => UserFieldDelete::class
            ],
            'deal.contact' => [
                Action::CREATE => DealContactAdd::class
            ]
        ];
    }

    public function getConfig(): array
    {
        $parent_config = parent::getConfig();
        return ArrayHelper::merge($parent_config, [
            'requestConfig' => [
                'options' => [
                    'ssl_verifypeer' => false,
                    'ssl_verifyhost' => false
                ],
                'class' => Query::class
            ]
        ]);
    }

    public function isBoxed()
    {
        return !$this->isCloud();
    }

    public function isCloud()
    {
        return strpos($this->url, static::CLOUD_DOMAIN) !== false;
    }
}
