<?php

namespace connect\crm\base\record;

use connect\crm\base\db\ActiveRecord;
use yii\db\ActiveQuery;

class ExternalReference extends ActiveRecord
{
    public function rules(): array
    {
        return [
            [['external_id_1', 'external_id_2'], 'integer'],
            [['external_id_1', 'external_id_2'], 'required']
        ];
    }

    public function getExternalRecords(): ActiveQuery
    {
        return (new ActiveQuery(ExternalRecord::class))->from([
            'union' => $this->getExternalRecord1()->union($this->getExternalRecord2())
        ]);
    }

    public function getExternalRecord1(): ActiveQuery
    {
        return $this->hasMany(ExternalRecord::class, ['id' => 'external_id_1'])->from(
            ExternalRecord::tableName() . ' external_record_1'
        );
    }

    public function getExternalRecord2(): ActiveQuery
    {
        return $this->hasMany(ExternalRecord::class, ['id' => 'external_id_2'])->from(
            ExternalRecord::tableName() . ' external_record_2'
        );
    }
}
