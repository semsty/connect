<?php

namespace connect\crm\bitrix24;

use connect\crm\base\dict\Action;
use connect\crm\base\Service as BaseService;
use connect\crm\bitrix24\action\Add;
use connect\crm\bitrix24\action\Auth;
use connect\crm\bitrix24\action\DealContactAdd;
use connect\crm\bitrix24\action\Delete;
use connect\crm\bitrix24\action\Fields;
use connect\crm\bitrix24\action\Get;
use connect\crm\bitrix24\action\ListAction;
use connect\crm\bitrix24\action\Update;
use connect\crm\bitrix24\action\UserFieldAdd;
use connect\crm\bitrix24\action\UserFieldDelete;
use connect\crm\bitrix24\action\UserFieldGet;
use connect\crm\bitrix24\action\UserFieldList;
use connect\crm\bitrix24\action\UserFieldUpdate;
use connect\crm\bitrix24\dict\Data;
use connect\crm\bitrix24\dict\Entities;
use connect\crm\bitrix24\dict\Fields as FieldsDictionary;
use connect\crm\bitrix24\dict\Selects;
use connect\crm\bitrix24\dict\Types;
use connect\crm\bitrix24\query\Query;
use yii\helpers\ArrayHelper;

/**
 * Class Service
 * @link https://dev.1c-bitrix.ru/rest_help/crm/
 * @package connect\crm\bitrix24
 */
class Service extends BaseService
{
    const ID = 5;
    const NAME = 'bitrix24';

    const CLOUD_DOMAIN = 'bitrix24.(ru|by|kz|ua)';
    const WEBHOOKS_PATTERN = '\/rest\/[\d]+\/[\w\d]+';

    public $url = 'https://{domain}/';
    public $formats = ['json'];

    protected $_domain;

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
        preg_match('/' . static::CLOUD_DOMAIN . '/', $this->_domain, $matches);
        return !empty($matches[0]);
    }

    /**
     * Разработчики Битрикс24 сделали доступ к API через ссылку и назвали это Webhooks - так не нужен разработчик.
     * Совсем. Программирующий маркетолог справится. Честное слово. Ведь это уже не REST API, это Webhooks!
     */
    public function isWebhooks()
    {
        preg_match('/' . static::WEBHOOKS_PATTERN . '/', $this->_domain, $matches);
        return !empty($matches[0]);
    }

    protected function setAuth(array $config)
    {
        $this->_domain = $config['domain'];
    }
}
