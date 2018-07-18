<?php

namespace connect\crm\base\traits;

use yii\helpers\ArrayHelper;
use yii\helpers\Json;

trait ExtraAttributesDbModel
{
    protected $_extra_attributes_column = 'extra_attributes';

    public function init()
    {
        parent::init();
        if ($this->getExtraAttributes()) {
            $this->_extra_attributes = $this->getExtraAttributes();
        }
    }

    public function getExtraAttributes()
    {
        return ArrayHelper::merge($this->getJsonField($this->_extra_attributes_column), $this->_extra_attributes);
    }

    public function afterFind()
    {
        parent::afterFind();
        if ($this->getExtraAttributes()) {
            $this->_extra_attributes = $this->getExtraAttributes();
        }
    }

    public function rules()
    {
        return [
            [['extra_attributes'], 'string'],
            [['extra_attributes'], 'default', 'value' => '{}'],
            [['extraAttributes'], 'safe']
        ];
    }

    public function setExtraAttributes($value)
    {
        $this->setJsonField($this->_extra_attributes_column, $value);
    }

    public function beforeSave($insert)
    {
        $column = $this->_extra_attributes_column;
        $this->$column = Json::encode($this->_extra_attributes);
        return parent::beforeSave($insert);
    }
}