<?php

namespace connect\crm\amocrm\action;

use connect\crm\amocrm\action\base\ListAction;
use connect\crm\amocrm\dict\Entities;
use connect\crm\base\dict\Action;
use yii\helpers\ArrayHelper;

/**
 * Class CustomFieldList
 * @property $subentity
 * @package connect\crm\amocrm\action
 */
class CustomFieldList extends ListAction
{
    const ID = 17;
    const NAME = Entities::CUSTOM_FIELD . Action::NAME_DELIMITER . Action::LIST;

    public $subentity = 'leads';

    protected $path = 'api/{version}/{subentity}/custom_fields';
    protected $entity = Entities::CUSTOM_FIELD;

    public function rules(): array
    {
        $rules = parent::rules();
        $rules = ArrayHelper::merge($rules, [
            [['subentity'], 'string']
        ]);
        return $rules;
    }

    public function run()
    {
        $data = parent::run();
        $this->service->schema->_info['custom_fields'] = ArrayHelper::merge(
            [$this->subentity => $data],
            ArrayHelper::getValue($this->service->schema->_info, ['custom_fields'], [])
        );
        return $data;
    }

    public function getQuery()
    {
        $query = parent::getQuery();
        $query['subentity'] = $this->subentity;
        return $query;
    }
}
