<?php

namespace connect\crm\bitrix24\action;

use connect\crm\base\traits\ProviderAction;
use connect\crm\bitrix24\action\base\Action;
use connect\crm\bitrix24\dict\Selects;
use yii\helpers\ArrayHelper;

class ListAction extends Action
{
    const ID = 5;
    const NAME = 'list';

    use ProviderAction;

    public $entity = 'deal';

    public $select = [];
    public $filter = [];
    public $order = [];
    public $start;
    public $prepare_select = false;
    public $max_offset = 0;

    public static function getSystemEntitiesFields()
    {
        return [
            'contact' => [
                'ID', 'HONORIFIC', 'NAME', 'SECOND_NAME', 'LAST_NAME', 'PHOTO', 'BIRTHDATE', 'TYPE_ID', 'SOURCE_ID',
                'SOURCE_DESCRIPTION', 'POST', 'ADDRESS', 'ADDRESS_2', 'ADDRESS_CITY', 'ADDRESS_POSTAL_CODE',
                'ADDRESS_REGION', 'ADDRESS_PROVINCE', 'ADDRESS_COUNTRY', 'ADDRESS_COUNTRY_CODE', 'COMMENTS',
                'OPENED', 'EXPORT', 'HAS_PHONE', 'HAS_EMAIL', 'ASSIGNED_BY_ID', 'CREATED_BY_ID', 'MODIFY_BY_ID',
                'DATE_CREATE', 'DATE_MODIFY', 'COMPANY_ID', 'COMPANY_IDS', 'LEAD_ID', 'ORIGINATOR_ID', 'ORIGIN_ID',
                'ORIGIN_VERSION', 'FACE_ID', 'UTM_SOURCE', 'UTM_MEDIUM', 'UTM_CAMPAIGN', 'UTM_CONTENT', 'UTM_TERM',
                'PHONE', 'EMAIL', 'WEB', 'IM'
            ],
            'deal' => [
                'ID', 'TITLE', 'TYPE_ID', 'CATEGORY_ID', 'STAGE_ID', 'STAGE_SEMANTIC_ID', 'IS_NEW', 'IS_RECURRING',
                'PROBABILITY', 'CURRENCY_ID', 'OPPORTUNITY', 'TAX_VALUE', 'COMPANY_ID', 'CONTACT_ID', 'CONTACT_IDS',
                'QUOTE_ID', 'BEGINDATE', 'CLOSEDATE', 'OPENED', 'CLOSED', 'COMMENTS', 'ASSIGNED_BY_ID', 'CREATED_BY_ID',
                'MODIFY_BY_ID', 'DATE_CREATE', 'DATE_MODIFY', 'LEAD_ID', 'ADDITIONAL_INFO', 'LOCATION_ID',
                'ORIGINATOR_ID', 'ORIGIN_ID', 'UTM_SOURCE', 'UTM_MEDIUM', 'UTM_CAMPAIGN', 'UTM_CONTENT', 'UTM_TERM',
            ],
            'lead' => [
                'ID', 'TITLE', 'HONORIFIC', 'NAME', 'SECOND_NAME', 'LAST_NAME', 'BIRTHDATE', 'COMPANY_TITLE',
                'SOURCE_ID', 'SOURCE_DESCRIPTION', 'STATUS_ID', 'STATUS_DESCRIPTION', 'STATUS_SEMANTIC_ID', 'POST',
                'ADDRESS', 'ADDRESS_2', 'ADDRESS_CITY', 'ADDRESS_POSTAL_CODE', 'ADDRESS_REGION', 'ADDRESS_PROVINCE',
                'ADDRESS_COUNTRY', 'ADDRESS_COUNTRY_CODE', 'CURRENCY_ID', 'OPPORTUNITY', 'OPENED', 'COMMENTS',
                'HAS_PHONE', 'HAS_EMAIL', 'ASSIGNED_BY_ID', 'CREATED_BY_ID', 'MODIFY_BY_ID', 'DATE_CREATE',
                'DATE_MODIFY', 'COMPANY_ID', 'CONTACT_ID', 'IS_RETURN_CUSTOMER', 'DATE_CLOSED', 'ORIGINATOR_ID',
                'ORIGIN_ID', 'UTM_SOURCE', 'UTM_MEDIUM', 'UTM_CAMPAIGN', 'UTM_CONTENT', 'UTM_TERM', 'PHONE', 'EMAIL',
                'WEB', 'IM'
            ]
        ];
    }

    public function rules(): array
    {
        $rules = parent::rules();
        $rules = ArrayHelper::merge($rules, [
            [['start'], 'integer'],
            [['start'], 'default', 'value' => 0]
        ]);
        return $rules;
    }

    public function getDefaultConfig(): array
    {
        return ArrayHelper::merge(parent::getDefaultConfig(), [
            'rateLimit' => [1, static::REQUEST_LIMIT],
            'limit_request_key' => 'start',
            'limit_response_key' => 'next',
            'max_limit' => $this->start,
            'max_offset' => $this->max_offset,
            'cursor' => 'result',
            'requestConfig' => [
                'url' => $this->getQuery()
            ]
        ]);
    }

    public function getQuery()
    {
        #TODO: логику формирования запроса вынести в \common\models\connect\query\*
        foreach ($this->filter as $field => $value) {
            if ($fields = $this->service->dictionaries->get($this->entity . '.multiple.fields')) {
                if (
                    ArrayHelper::isIn($field, $fields)
                    &&
                    is_array($value)
                    &&
                    ArrayHelper::keyExists('VALUE', $value[0])
                ) {
                    $this->filter[$field] = $value[0]['VALUE'];
                }
            }
        }
        return [
            'domain' => $this->domain,
            'select' => $this->select,
            'filter' => $this->filter,
            'order' => $this->order
        ];
    }

    public function getPath(): string
    {
        return 'rest/crm.' . $this->entity . '.list';
    }

    public function getResponse(): array
    {
        return $this->connection->sendWithOffset();
    }

    public function run()
    {
        $this->prepareSelect();
        return parent::run();
    }

    public function prepareSelect()
    {
        $info = $this->service->schema->info;
        if ($info && ArrayHelper::getValue($info, $this->entity)) {
            $this->select = array_keys($info[$this->entity]);
        } else {
            $this->select = Selects::dictSelects();
        }
    }

    public function setEntity($value)
    {
        $this->entity = $value;
        if ($this->prepare_select) {
            $this->prepareSelect();
        }
    }
}
