<?php

namespace semsty\connect\base\db;

use semsty\connect\base\data\BaseData;
use semsty\connect\base\helpers\ArrayHelper;
use semsty\connect\base\helpers\Json;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord as BaseActiveRecord;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/**
 * @property $created_at
 * @property $updated_at
 */
class ActiveRecord extends BaseActiveRecord
{
    const TIME_CREATED = BaseData::TIME_CREATED;
    const TIME_UPDATED = BaseData::TIME_UPDATED;

    public static function getOrCreate($condition)
    {
        $model = static::find()->where($condition)->one();
        if (empty($model) && !ArrayHelper::keyExists('id', $condition)) {
            $model = new static;
            foreach ($condition as $attribute => $value) {
                $model->$attribute = $value;
            }
            $model->save();
        }
        return $model;
    }

    public static function tableName()
    {
        return Inflector::camel2id(StringHelper::basename(get_called_class()), '_');
    }

    public function behaviors()
    {
        $behaviors = [];
        foreach ([
                     static::EVENT_BEFORE_INSERT => static::TIME_CREATED,
                     static::EVENT_BEFORE_UPDATE => static::TIME_UPDATED
                 ] as $event => $param) {
            if ($this->getTableSchema()->getColumn($param)) {
                $attributes[$event] = $param;
            }
        }
        if (isset($attributes)) {
            $behaviors['timestamp'] = [
                'class' => TimestampBehavior::className(),
                'attributes' => $attributes,
                'value' => function () {
                    return date('U');
                },
            ];
        }
        return $behaviors;
    }

    public function getDateCreated()
    {
        return \Yii::$app->formatter->asDate($this->created_at);
    }

    public function getTimeCreated()
    {
        return \Yii::$app->formatter->asDatetime($this->created_at);
    }

    public function setTimeCreated($datetime)
    {
        $this->created_at = strtotime($datetime);
    }

    public function getTimeUpdated()
    {
        $time = $this->updated_at;
        if (empty($time)) {
            $time = $this->created_at;
        }
        return \Yii::$app->formatter->asDatetime($time);
    }

    public function setTimeUpdated($datetime)
    {
        $this->updated_at = strtotime($datetime);
    }

    public function setJsonField($attribute, $value)
    {
        if (is_array($value)) {
            $this->$attribute = Json::encode($value);
        } elseif (is_string($value)) {
            $this->$attribute = $value;
        }
    }

    public function getJsonField($attribute)
    {
        if (is_array($this->$attribute)) {
            return $this->$attribute;
        } else {
            return Json::decode($this->$attribute);
        }
    }
}
