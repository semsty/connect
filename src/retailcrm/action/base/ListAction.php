<?php

namespace connect\crm\retailcrm\action\base;

use connect\crm\base\traits\ProviderAction;
use connect\crm\retailcrm\filter\base\Filter;
use yii\helpers\ArrayHelper;

class ListAction extends Action
{
    use ProviderAction;

    public $_filter_class = Filter::class;
    /**
     * @var Filter
     */
    public $_filter;
    public $limit;
    public $offset = 0;
    public $max_offset = 0;
    public $page = 1;
    public $keys = [];
    protected $path = '/api/{version}/{entity}s';

    public function __construct(array $config = [])
    {
        $className = $this->_filter_class;
        $this->_filter = new $className();
        parent::__construct($config);
    }

    public function rules(): array
    {
        return ArrayHelper::merge(parent::rules(), [
            [['limit'], 'default', 'value' => static::MAX_LIMIT],
            [['limit'], 'in', 'range' => [20, 50, 100]],
            ['filter', 'safe']
        ]);
    }

    public function getDefaultConfig(): array
    {
        return [
            'rateLimit' => [1, static::REQUEST_LIMIT],
            'limit_request_key' => 'limit',
            'offset_request_key' => 'page',
            'offset_response_key' => 'pagination.totalPageCount',
            'offset_increment' => 1,
            'max_limit' => $this->limit,
            'max_offset' => $this->max_offset,
            'current_offset' => $this->offset,
            'cursor' => $this->getEntityResponseName(),
            'requestConfig' => [
                'url' => [
                    'filter' => $this->getFilter()
                ]
            ]
        ];
    }

    public function getEntityResponseName()
    {
        return $this->getEntityPluralizeName();
    }

    public function getFilter()
    {
        return $this->_filter->serialize();
    }

    public function setFilter($data)
    {
        $this->_filter->setAttributes($data);
    }

    public function getResponse(): array
    {
        return $this->connection->all();
    }
}
