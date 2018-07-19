<?php

namespace connect\crm\amocrm;

use connect\crm\amocrm\action\Auth;
use connect\crm\amocrm\action\CompanyList;
use connect\crm\amocrm\action\CompanySet;
use connect\crm\amocrm\action\ContactsList;
use connect\crm\amocrm\action\ContactsSet;
use connect\crm\amocrm\action\CustomFieldsSet;
use connect\crm\amocrm\action\Info;
use connect\crm\amocrm\action\LeadsList;
use connect\crm\amocrm\action\LeadsSet;
use connect\crm\amocrm\action\NotesList;
use connect\crm\amocrm\action\NotesSet;
use connect\crm\amocrm\action\TasksList;
use connect\crm\amocrm\action\TasksSet;
use connect\crm\amocrm\dict\Data;
use connect\crm\amocrm\dict\Entities;
use connect\crm\amocrm\dict\Errors;
use connect\crm\amocrm\dict\Fields;
use connect\crm\amocrm\dict\Types;
use connect\crm\amocrm\query\Query;
use connect\crm\amocrm\query\Response;
use connect\crm\base\dict\Action;
use connect\crm\base\Service as BaseService;
use yii\helpers\ArrayHelper;

/**
 * Class Service
 * @link https://www.amocrm.ru/developers/content/api/auth
 * @package connect\crm\amocrm
 */
class Service extends BaseService
{
    const ID = 1;
    const NAME = 'amocrm';

    public $url = 'https://{subdomain}.amocrm.ru/';
    public $formats = ['json'];

    public static function getDictionariesList(): array
    {
        return ArrayHelper::merge(parent::getDictionariesList(), [
            Data::class,
            Types::class,
            Errors::class,
            Entities::class,
            Fields::class
        ]);
    }

    public static function getDataProviderActions(): array
    {
        return [
            Action::AUTH => Auth::class,
            Action::INFO => Info::class,
            Entities::LEAD => [
                Action::LIST => LeadsList::class,
                Action::GET => LeadsList::class
            ],
            Entities::CONTACT => [
                Action::LIST => ContactsList::class,
                Action::GET => ContactsList::class
            ],
            Entities::NOTE => [
                Action::LIST => NotesList::class,
                Action::GET => NotesList::class
            ],
            Entities::COMPANY => [
                Action::LIST => CompanyList::class,
                Action::GET => CompanyList::class
            ],
            Entities::TASK => [
                Action::LIST => TasksList::class,
                Action::GET => TasksList::class
            ]
        ];
    }

    public static function getDataRecipientActions(): array
    {
        return [
            Entities::LEAD => [
                Action::CREATE => LeadsSet::class,
                Action::UPDATE => LeadsSet::class
            ],
            Entities::CONTACT => [
                Action::CREATE => ContactsSet::class,
                Action::UPDATE => ContactsSet::class
            ],
            Entities::NOTE => [
                Action::CREATE => NotesSet::class,
                Action::UPDATE => NotesSet::class
            ],
            Entities::COMPANY => [
                Action::CREATE => CompanySet::class,
                Action::UPDATE => CompanySet::class
            ],
            Entities::TASK => [
                Action::CREATE => TasksSet::class,
                Action::UPDATE => TasksSet::class
            ],
            Entities::CUSTOM_FIELD => [
                Action::CREATE => CustomFieldsSet::class,
                Action::UPDATE => CustomFieldsSet::class
            ]
        ];
    }

    public function getConfig(): array
    {
        return ArrayHelper::merge(parent::getConfig(), [
            'requestConfig' => [
                'options' => [
                    'timeout' => 60
                ],
                'class' => Query::class
            ],
            'responseConfig' => [
                'class' => Response::class
            ]
        ]);
    }
}
