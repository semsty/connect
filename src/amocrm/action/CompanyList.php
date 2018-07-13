<?php

namespace semsty\connect\amocrm\action;

use semsty\connect\amocrm\action\base\ListAction;
use semsty\connect\amocrm\dict\Entities;
use semsty\connect\base\dict\Action;
use yii\helpers\ArrayHelper;

class CompanyList extends ListAction
{
    const ID = 5;
    const NAME = Entities::COMPANY . Action::NAME_DELIMITER . Action::LIST;
    public $type;
    public $responsible_user_id;
    protected $path = 'api/{version}/companies';
    protected $entity = Entities::COMPANY;

    public function rules(): array
    {
        $rules = parent::rules();
        $rules = ArrayHelper::merge($rules, [
            [['type'], 'default', 'value' => static::getTypes()[0]],
            ['type', 'in', 'range' => static::getTypes()],
            [['responsible_user_id'], 'integer']
        ]);
        return $rules;
    }

    public static function getTypes()
    {
        return ['company', 'all'];
    }

    public function getQuery()
    {
        $query = parent::getQuery();
        $query['type'] = $this->type;
        $query['responsible_user_id'] = $this->responsible_user_id;
        $query['id'] = $this->id;
        return $query;
    }

    public function getEntityPluralizeName(): string
    {
        return 'companies';
    }
}
