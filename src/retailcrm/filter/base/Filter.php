<?php

namespace semsty\connect\retailcrm\filter\base;

use semsty\connect\base\helpers\ArrayHelper;
use yii\base\Model;

/**
 * Class Filter
 */
class Filter extends Model
{
    const FILTER_MAX = 'max';
    const FILTER_MIN = 'min';

    /**
     * @var array $customFields
     */
    public $customFields = [];

    /**
     * @return array
     */
    public function serialize(): array
    {
        $result = [];
        if ($this->validate()) {
            $map = static::map();
            foreach ($this->getAttributes() as $attribute => $value) {
                if ($value) {
                    if ($filter = ArrayHelper::getValue($map, $attribute)) {
                        $attribute = $filter;
                    }
                    $result[$attribute] = $value;
                }
            }
        }
        return $result;
    }

    /**
     * @return array
     */
    public static function map(): array
    {
        return [
            'source' => 'sourceName',
            'medium' => 'mediumName',
            'campaign' => 'campaignName',
            'keyword' => 'keywordName',
            'content' => 'adContentName'
        ];
    }
}
