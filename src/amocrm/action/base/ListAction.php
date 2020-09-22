<?php

namespace connect\crm\amocrm\action\base;

use connect\crm\base\traits\ProviderAction;
use yii\helpers\ArrayHelper;

/**
 * Class ListAction
 * @property $id
 * @property $query
 * @property $filter
 * @property $order
 * @property $with
 * @package connect\crm\amocrm\action\base
 */
class ListAction extends Action
{
    use ProviderAction;

    const IDS_CHUNK_SIZE = 100;

    public $id;
    public $filter = [];
    public $query = [];
    public $limit;
    public $page;
    public $max_offset = 0;
    public $offset = 0;
    public $eav_key = 'custom_fields';
    public $eav_name_key = 'name';
    public $eav_value_key = 'values.0.value';
    public $order = [];
    public $with = [];

    public function rules(): array
    {
        $rules = parent::rules();
        $rules = ArrayHelper::merge($rules, [
            [['limit', 'page'], 'integer'],
            [['limit'], 'default', 'value' => static::MAX_LIMIT],
            [['page'], 'default', 'value' => static::MAX_LIMIT]
        ]);
        return $rules;
    }

    public function getDefaultConfig(): array
    {
        $config = ArrayHelper::merge(parent::getDefaultConfig(), [
            'rateLimit' => [1, static::REQUEST_LIMIT],
            'limit_request_key' => 'limit',
            'offset_request_key' => 'page',
            'offset_response_key' => '_embedded.' . $this->getEntityPluralizeName(),
            'max_limit' => $this->limit,
            'max_offset' => $this->max_offset,
            'offset_increment' => 1,
            'current_offset' => $this->page,
            'cursor' => '_embedded.' . $this->getEntityPluralizeName(),
            'requestConfig' => [
                'url' => $this->getQuery()
            ]
        ]);
        return $config;
    }

    public function getQuery()
    {
        return [
            'query' => $this->query,
            'filter' => $this->filter,
            'order' => $this->order,
            'with' => $this->with
        ];
    }

    public function getResponse(): array
    {
        if ($this->id) {
            $result = [];
            $ids = $this->id;
            foreach (array_chunk($ids, static::IDS_CHUNK_SIZE) as $chunk) {
                $this->id = $chunk;
                $result = ArrayHelper::merge(
                    $result,
                    ArrayHelper::getValue(parent::getResponse(), '_embedded.' . $this->getEntityPluralizeName(), [])
                );
            }
            return $result;
        } else {
            return $this->connection->all();
        }
    }
}
