<?php

namespace connect\crm\amocrm\action;

use connect\crm\amocrm\action\base\ListAction;
use connect\crm\amocrm\dict\Entities;
use connect\crm\base\dict\Action;
use yii\helpers\ArrayHelper;

class PipelineList extends ListAction
{
    const ID = 18;
    const NAME = Entities::PIPELINE . Action::NAME_DELIMITER . Action::LIST;

    protected $path = 'api/{version}/leads/pipelines';
    protected $entity = Entities::PIPELINE;

    public function run()
    {
        $data = parent::run();
        $this->service->schema->_info['pipelines'] = $data;
        return $data;
    }
}
