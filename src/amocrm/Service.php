<?php

namespace semsty\connect\amocrm;

use semsty\connect\amocrm\action\Auth;
use semsty\connect\amocrm\action\CompanyList;
use semsty\connect\amocrm\action\CompanySet;
use semsty\connect\amocrm\action\ContactsList;
use semsty\connect\amocrm\action\ContactsSet;
use semsty\connect\amocrm\action\CustomFieldsSet;
use semsty\connect\amocrm\action\Info;
use semsty\connect\amocrm\action\LeadsList;
use semsty\connect\amocrm\action\LeadsSet;
use semsty\connect\amocrm\action\NotesList;
use semsty\connect\amocrm\action\NotesSet;
use semsty\connect\amocrm\action\TasksList;
use semsty\connect\amocrm\action\TasksSet;
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
