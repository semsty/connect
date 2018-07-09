<?php

namespace semsty\connect\amocrm\actions\base;

use semsty\connect\base\traits\ProviderAction;
use yii\helpers\ArrayHelper;

class ListAction extends Action
{
    use ProviderAction;

    const IDS_CHUNK_SIZE = 100;

    public $modifiedSince = '';
    public $query = [];
    public $limit_rows;
    public $limit_offset;
    public $max_offset = 0;
    public $keys = [];
    public $defaults = [];
    public $default_keys = [];
    public $eav_key = 'custom_fields';
    public $eav_name_key = 'name';
    public $eav_value_key = 'values.0.value';

    public function rules(): array
    {
        $rules = parent::rules();
        $rules = ArrayHelper::merge($rules, [
            //[['modifiedSince'], 'date', 'format' => 'php:Y-m-d'],
            [['modifiedSince'], 'default', 'value' => \Yii::$app->formatter->asDatetime('now')],
            [['limit_rows', 'limit_offset'], 'integer'],
            [['limit_rows'], 'default', 'value' => static::MAX_LIMIT],
            [['limit_offset'], 'default', 'value' => static::MAX_LIMIT]
        ]);
        return $rules;
    }

    public function getDefaultConfig(): array
    {
        return ArrayHelper::merge(parent::getDefaultConfig(), [
            'rateLimit' => [1, static::REQUEST_LIMIT],
            'limit_request_key' => 'limit_rows',
            'offset_request_key' => 'limit_offset',
            'offset_response_key' => '_embedded.items',
            'max_limit' => $this->limit_rows,
            'max_offset' => $this->max_offset,
            'offset_increment' => $this->limit_offset,
            'current_offset' => 0,
            'cursor' => '_embedded.items',
            'requestConfig' => [
                'url' => $this->getQuery(),
                'headers' => [
                    'if-modified-since' => \Yii::$app->formatter->asDatetime(
                        $this->modifiedSince,
                        static::MODIFIED_SINCE_FORMAT
                    )
                ]
            ]
        ]);
    }

    public function getQuery()
    {
        return ['query' => $this->query];
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
                    ArrayHelper::getValue(parent::getResponse(), '_embedded.items', [])
                );
            }
            return $result;
        } else {
            return $this->client->sendWithOffset();
        }
    }

    public function setDateParam($date)
    {
        $this->modifiedSince = $date;
    }

    public function run()
    {
        $data = parent::run();
        $keys = ArrayHelper::merge($this->default_keys, $this->keys);
        if ($keys) {
            if (ArrayHelper::isAssociative($data)) {
                $this->serialize($data, $keys, $this->defaults);
            } else {
                $this->serializeIterable($data, $keys, $this->defaults);
            }
        }
        return $data;
    }
}
