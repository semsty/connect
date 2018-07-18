<?php

namespace connect\crm\tests\base\record;

use connect\crm\base\record\ExternalRecord;
use connect\crm\tests\base\TestCase;

class ExternalRecordTest extends TestCase
{
    public function testSetExtraAttributes()
    {
        $er = new ExternalRecord();
        $er->external_id = 1;
        $er->profile_id = 1;
        $er->type = 'lead';
        expect($er->getExtraAttributes())->null();
        expect($er->save())->true();
        $id = $er->id;
        $er->external_attribute = 'external_value';
        expect($er->getExtraAttributes())->equals([
            'external_attribute' => 'external_value'
        ]);
        expect($er->external_attribute)->equals('external_value');
        expect($er->save())->true();
        $er->external_attribute2 = 'external_value2';
        expect($er->getExtraAttributes())->equals([
            'external_attribute' => 'external_value',
            'external_attribute2' => 'external_value2'
        ]);
        expect($er->external_attribute)->equals('external_value');
        expect($er->external_attribute2)->equals('external_value2');
        expect($er->save())->true();
        $er = ExternalRecord::findOne($id);
        expect($er->getExtraAttributes())->equals([
            'external_attribute' => 'external_value',
            'external_attribute2' => 'external_value2'
        ]);
    }
}