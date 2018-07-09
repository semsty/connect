<?php

namespace semsty\connect\amocrm;

use semsty\connect\amocrm\actions\Auth;
use semsty\connect\amocrm\actions\CallsSet;
use semsty\connect\amocrm\actions\CompanyList;
use semsty\connect\amocrm\actions\CompanySet;
use semsty\connect\amocrm\actions\ContactsList;
use semsty\connect\amocrm\actions\ContactsSet;
use semsty\connect\amocrm\actions\CustomFieldsSet;
use semsty\connect\amocrm\actions\Info;
use semsty\connect\amocrm\actions\LeadsList;
use semsty\connect\amocrm\actions\LeadsSet;
use semsty\connect\amocrm\actions\NotesList;
use semsty\connect\amocrm\actions\NotesSet;
use semsty\connect\amocrm\actions\TasksList;
use semsty\connect\amocrm\actions\TasksSet;
use semsty\connect\amocrm\dict\Data;
use semsty\connect\amocrm\dict\Entities;
use semsty\connect\amocrm\dict\Errors;
use semsty\connect\amocrm\dict\Fields;
use semsty\connect\amocrm\dict\Types;
use semsty\connect\amocrm\query\Query;
use semsty\connect\amocrm\query\Response;
use semsty\connect\base\dict\Action;
use semsty\connect\base\Service as BaseService;
use yii\helpers\ArrayHelper;

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
            Entities::CALL => [
                Action::CREATE => CallsSet::class,
                Action::UPDATE => CallsSet::class
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
