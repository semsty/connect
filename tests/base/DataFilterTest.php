<?php

namespace connect\crm\tests\base;

use connect\crm\base\data\Filter as DataFilter;

class DataFilterTest extends TestCase
{
    public function testAndConditionFilter()
    {
        $data = [
            'id' => 1,
            'name' => 'name'
        ];
        $filter = [
            'and' => [
                'id' => 1,
                'name' => [
                    'in' => ['name']
                ]
            ]
        ];
        expect(DataFilter::filter($data, $filter))->true();
    }

    public function testOrConditionFilter()
    {
        $data = [
            'id' => 1,
            'name' => 'name'
        ];
        $filter = [
            'or' => [
                'id' => 1,
                'name' => [
                    'in' => ['another name']
                ]
            ]
        ];
        expect(DataFilter::filter($data, $filter))->true();
    }

    public function testComplexConditionFilter()
    {
        $data = [
            'id' => 1,
            'name' => 'name',
            'phone' => '88005553535'
        ];
        $filter = [
            'and' => [
                'or' => [
                    'id' => 2,
                    'name' => [
                        'in' => ['name']
                    ]
                ],
                'id' => 1
            ]
        ];
        expect(DataFilter::filter($data, $filter))->true();
        $filter = [
            'and' => [
                'or' => [
                    'or' => [
                        'id' => 2,
                        'name' => [
                            'in' => ['name']
                        ]
                    ],
                    'phone' => '88005553535'
                ],
                'id' => [
                    'gte' => 0
                ]
            ]
        ];
        expect(DataFilter::filter($data, $filter))->true();
    }

    public function testNormalizeFilterKey()
    {
        expect(DataFilter::normalizeFilter('not equal'))->equals('!=');
        expect(DataFilter::normalizeFilter('not_equal'))->equals('!=');
        expect(DataFilter::normalizeFilter('NoT EqUal'))->equals('!=');
        expect(DataFilter::normalizeFilter('not-equal'))->equals('!=');
    }

    public function testEqualFilter()
    {
        $data = [
            'id' => 1
        ];
        $filter = [
            'id' => 1
        ];
        expect(DataFilter::filter($data, $filter))->true();
        $filter = [
            'id' => ['equal' => 1]
        ];
        expect(DataFilter::filter($data, $filter))->true();
    }

    public function testInternalCompare()
    {
        $data = [
            'id' => 1,
            'external_id' => 1
        ];
        $filter = [
            'id' => 'internal:external_id'
        ];
        expect(DataFilter::filter($data, $filter))->true();
    }

    public function testVariativeModes()
    {
        $data = [
            'id' => 1,
            'external_id' => 1
        ];
        $filter = [
            'id' => 1
        ];
        expect(DataFilter::filter($data, $filter))->true();
        $filter = [
            ['id' => 1]
        ];
        expect(DataFilter::filter($data, $filter))->true();
        $filter = [
            ['id' => ['eq' => 1]]
        ];
        expect(DataFilter::filter($data, $filter))->true();
        $filter = [
            ['id' => ['eq' => 1]],
            'external_id' => 1
        ];
        expect(DataFilter::filter($data, $filter))->true();
    }
}
