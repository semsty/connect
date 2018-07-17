<?php

namespace tests\base\record;

use Codeception\Test\Unit;
use yii\helpers\ArrayHelper;
use semsty\connect\base\record\ExternalRecord;
use semsty\connect\base\record\ExternalReference;

class ExternalReferenceTest extends Unit
{
    public function testManyToManyReferences()
    {
        $er[0] = new ExternalRecord([
            'external_id' => 1,
            'profile_id' => 1,
            'type' => 'order'
        ]);
        $er[0]->save();
        $er[1] = new ExternalRecord([
            'external_id' => 2,
            'profile_id' => 1,
            'type' => 'order'
        ]);
        $er[1]->save();
        $er[2] = new ExternalRecord([
            'external_id' => 3,
            'profile_id' => 1,
            'type' => 'order'
        ]);
        $er[2]->save();
        $refs[0] = new ExternalReference([
            'external_id_1' => $er[0]->id,
            'external_id_2' => $er[1]->id
        ]);
        $refs[0]->save();
        $refs[1] = new ExternalReference([
            'external_id_1' => $er[0]->id,
            'external_id_2' => $er[2]->id
        ]);
        $refs[1]->save();
        expect(
            ArrayHelper::getColumn($er[0]->getReferenceRecords()->all(), 'id')
        )->equals([$er[1]->id, $er[2]->id]);
        expect(
            ArrayHelper::getColumn($er[1]->getReferenceRecords()->all(), 'id')
        )->equals([$er[0]->id]);
        expect(
            ArrayHelper::getColumn($er[2]->getReferenceRecords()->all(), 'id')
        )->equals([$er[0]->id]);
    }
}
