<?php

namespace semsty\connect\base\record;

use semsty\connect\base\dict\Entities;
use semsty\connect\base\Profile;
use semsty\connect\base\Service;
use semsty\connect\base\traits\ExtraAttributesDbModel;
use semsty\connect\base\traits\ExtraAttributesModel;
use semsty\connect\Settings;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Class ExternalRecord
 * @property $id
 * @property $profile BaseProfile
 * @property $external_id
 * @property $profile_id
 * @property $integration Integration
 * @property $type
 * @property $extraAttributes
 * @package common\models\connect\record\base
 */
class ExternalRecord extends ActiveRecord
{
    use ExtraAttributesModel, ExtraAttributesDbModel;

    const DEFAULT_TYPE = Entities::ENTITY;
    /**
     * @var $service Service
     */
    public $_service;

    public function init()
    {
        parent::init();
        $this->type = static::DEFAULT_TYPE;
    }

    public function rules()
    {
        return [
            ['external_id', 'filter', 'filter' => function ($value) {
                return (string)$value;
            }],
            [['type', 'external_id'], 'string'],
            [['profile_id'], 'integer'],
            [['profile_id', 'external_id', 'type'], 'required'],
            [['extra_attributes'], 'string'],
            [['extra_attributes'], 'default', 'value' => '{}'],
            [['extraAttributes'], 'safe']
        ];
    }

    public function setDefaultAttributes($values)
    {
        $result = [];
        foreach (static::getDefaultStoredAttributes() as $assoc => $attribute) {
            if (is_numeric($assoc)) {
                $result[$attribute] = ArrayHelper::getValue($values, $attribute);
            } else {
                $result[$assoc] = ArrayHelper::getValue($values, $attribute);
            }
        }
        $this->setAttributes($result);
    }

    public static function getDefaultStoredAttributes()
    {
        return [];
    }

    public function getService()
    {
        if (empty($this->_service)) {
            $class = Settings::getServices()[$this->profile->service_id];
            $this->_service = new $class(['profile' => $this->profile]);
        }
        return $this->_service;
    }

    public function getProfile(): ActiveQuery
    {
        return $this->hasOne(Profile::class, ['id' => 'profile_id']);
    }

    public function getExternalReferences(): ActiveQuery
    {
        $query = $this->getExternalReferences1()->union($this->getExternalReferences2());
        $query->multiple = true;
        return $query;
    }

    public function getExternalReferences1(): ActiveQuery
    {
        return $this->hasMany(ExternalReference::class, ['external_id_1' => 'id']);
    }

    public function getExternalReferences2(): ActiveQuery
    {
        return $this->hasMany(ExternalReference::class, ['external_id_2' => 'id']);
    }

    public function getReferenceRecords(): ActiveQuery
    {
        $query = $this->getReferenceRecords1()->union($this->getReferenceRecords2());
        $query->multiple = true;
        return $query;
    }

    public function getReferenceRecords1(): ActiveQuery
    {
        return $this->hasMany(static::class, ['id' => 'external_id_1'])
            ->from(static::tableName() . ' reference_records_1')
            ->via('externalReferences2');
    }

    public static function tableName()
    {
        return '{{%external_record}}';
    }

    public function getReferenceRecords2(): ActiveQuery
    {
        return $this->hasMany(static::class, ['id' => 'external_id_2'])
            ->from(static::tableName() . ' reference_records_2')
            ->via('externalReferences1');
    }

    public function bind(ExternalRecord $record)
    {
        (new ExternalReference([
            'external_id_1' => $this->id,
            'external_id_2' => $record->id
        ]))->save();
    }
}
