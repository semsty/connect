<?php

namespace connect\crm\amocrm\action;

use connect\crm\amocrm\action\base\ListAction;
use connect\crm\amocrm\dict\Entities;
use connect\crm\base\dict\Action;
use yii\helpers\ArrayHelper;

class ContactsList extends ListAction
{
    const ID = 4;
    const NAME = Entities::CONTACT . Action::NAME_DELIMITER . Action::LIST;
    public $type;
    public $responsible_user_id;
    protected $path = 'api/{version}/contacts';
    protected $entity = Entities::CONTACT;

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
        return ['contact', 'company', 'all'];
    }

    public function getQuery()
    {
        $query = parent::getQuery();
        $query['type'] = $this->type;
        $query['responsible_user_id'] = $this->responsible_user_id;
        $query['id'] = $this->id;
        return $query;
    }
}
