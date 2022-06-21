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

    public function testStrpos()
    {
        $data = [
            'id' => 1,
            'foo' => 'foobarbaz'
        ];
        $filter = [
            'foo' => ['strpos' => 'obar']
        ];
        expect(DataFilter::filter($data, $filter))->true();
        $filter = [
            'foo' => ['strpos' => 'obarr']
        ];
        expect(DataFilter::filter($data, $filter))->false();

        $data = [
            'id' => 1,
            'foo' => 'фуубарбаз'
        ];
        $filter = [
            'foo' => ['strpos' => 'убар']
        ];
        expect(DataFilter::filter($data, $filter))->true();
        $filter = [
            'foo' => ['strpos' => 'убарр']
        ];
        expect(DataFilter::filter($data, $filter))->false();
    }

    public function testNotStrpos()
    {
        $data = [
            'id' => 1,
            'foo' => 'foobarbaz'
        ];
        $filter = [
            'foo' => ['not-strpos' => 'obar']
        ];
        expect(DataFilter::filter($data, $filter))->false();
        $filter = [
            'foo' => ['not-strpos' => 'obarr']
        ];
        expect(DataFilter::filter($data, $filter))->true();

        $data = [
            'id' => 1,
            'foo' => 'фуубарбаз'
        ];
        $filter = [
            'foo' => ['not-strpos' => 'убар']
        ];
        expect(DataFilter::filter($data, $filter))->false();
        $filter = [
            'foo' => ['not-strpos' => 'убарр']
        ];
        expect(DataFilter::filter($data, $filter))->true();
    }

    public function testStripos()
    {
        $data = [
            'id' => 1,
            'foo' => 'foobarbaz'
        ];
        $filter = [
            'foo' => ['stripos' => 'ObAr']
        ];
        expect(DataFilter::filter($data, $filter))->true();
        $filter = [
            'foo' => ['stripos' => 'ObArr']
        ];
        expect(DataFilter::filter($data, $filter))->false();

        $data = [
            'id' => 1,
            'foo' => 'фуубарбаз'
        ];
        $filter = [
            'foo' => ['stripos' => 'УбАр']
        ];
        expect(DataFilter::filter($data, $filter))->true();
        $filter = [
            'foo' => ['stripos' => 'УбАрр']
        ];
        expect(DataFilter::filter($data, $filter))->false();
    }

    public function testNotStripos()
    {
        $data = [
            'id' => 1,
            'foo' => 'foobarbaz'
        ];
        $filter = [
            'foo' => ['not-stripos' => 'ObAr']
        ];
        expect(DataFilter::filter($data, $filter))->false();
        $filter = [
            'foo' => ['not-stripos' => 'ObArr']
        ];
        expect(DataFilter::filter($data, $filter))->true();

        $data = [
            'id' => 1,
            'foo' => 'фуубарбаз'
        ];
        $filter = [
            'foo' => ['not-stripos' => 'УбАр']
        ];
        expect(DataFilter::filter($data, $filter))->false();
        $filter = [
            'foo' => ['not-stripos' => 'УбАрр']
        ];
        expect(DataFilter::filter($data, $filter))->true();
    }

    public function testStartsWith()
    {
        $data = [
            'id' => 1,
            'foo' => 'foobarbaz'
        ];
        $filter = [
            'foo' => ['starts-with' => 'foo']
        ];
        expect(DataFilter::filter($data, $filter))->true();
        $filter = [
            'foo' => ['starts-with' => 'bar']
        ];
        expect(DataFilter::filter($data, $filter))->false();

        $data = [
            'id' => 1,
            'foo' => 'фуубарбаз'
        ];
        $filter = [
            'foo' => ['starts-with' => 'фуу']
        ];
        expect(DataFilter::filter($data, $filter))->true();
        $filter = [
            'foo' => ['starts-with' => 'бар']
        ];
        expect(DataFilter::filter($data, $filter))->false();
    }

    public function testNotStartsWith()
    {
        $data = [
            'id' => 1,
            'foo' => 'foobarbaz'
        ];
        $filter = [
            'foo' => ['not-starts-with' => 'foo']
        ];
        expect(DataFilter::filter($data, $filter))->false();
        $filter = [
            'foo' => ['not-starts-with' => 'bar']
        ];
        expect(DataFilter::filter($data, $filter))->true();

        $data = [
            'id' => 1,
            'foo' => 'фуубарбаз'
        ];
        $filter = [
            'foo' => ['not-starts-with' => 'фуу']
        ];
        expect(DataFilter::filter($data, $filter))->false();
        $filter = [
            'foo' => ['not-starts-with' => 'бар']
        ];
        expect(DataFilter::filter($data, $filter))->true();
    }

    public function testEndsWith()
    {
        $data = [
            'id' => 1,
            'foo' => 'foobarbaz'
        ];
        $filter = [
            'foo' => ['ends-with' => 'bar']
        ];
        expect(DataFilter::filter($data, $filter))->false();
        $filter = [
            'foo' => ['ends-with' => 'baz']
        ];
        expect(DataFilter::filter($data, $filter))->true();

        $data = [
            'id' => 1,
            'foo' => 'фуубарбаз'
        ];
        $filter = [
            'foo' => ['ends-with' => 'бар']
        ];
        expect(DataFilter::filter($data, $filter))->false();
        $filter = [
            'foo' => ['ends-with' => 'баз']
        ];
        expect(DataFilter::filter($data, $filter))->true();
    }

    public function testNotEndsWith()
    {
        $data = [
            'id' => 1,
            'foo' => 'foobarbaz'
        ];
        $filter = [
            'foo' => ['not-ends-with' => 'baz']
        ];
        expect(DataFilter::filter($data, $filter))->false();
        $filter = [
            'foo' => ['not-ends-with' => 'bar']
        ];
        expect(DataFilter::filter($data, $filter))->true();

        $data = [
            'id' => 1,
            'foo' => 'фуубарбаз'
        ];
        $filter = [
            'foo' => ['not-ends-with' => 'баз']
        ];
        expect(DataFilter::filter($data, $filter))->false();
        $filter = [
            'foo' => ['not-ends-with' => 'бар']
        ];
        expect(DataFilter::filter($data, $filter))->true();
    }

    public function testInverse()
    {
        $filter = [
            'foo' => ['eq' => 'bar'],
            'bar' => 'baz',
            'baz' => ['not-in' => ['foo']]
        ];
        $expected = [
            'or' => [
                'foo' => ['not-eq' => 'bar'],
                'bar' => ['!=' => 'baz'],
                'baz' => ['in' => ['foo']]
            ]
        ];
        expect(DataFilter::inverse($filter))->equals($expected);
    }

    public function testNestedInverse()
    {
        $filter = [
            'foo' => ['eq' => 'bar'],
            'and' => [
                'bar' => 'baz',
                'baz' => [
                    'in' => ['bar', 'foo']
                ]
            ]
        ];
        $expected = [
            'or' => [
                'foo' => ['not-eq' => 'bar'],
                'or' => [
                    'bar' => ['!=' => 'baz'],
                    'baz' => [
                        'not-in' => ['bar', 'foo']
                    ]
                ]
            ]
        ];
        expect(DataFilter::inverse($filter))->equals($expected);
    }

    public function testNestedDisjunctionInverse()
    {
        $filter = [
            'or' => [
                'foo' => ['eq' => 'bar'],
                'and' => [
                    'bar' => 'baz',
                    'baz' => [
                        'in' => ['bar', 'foo']
                    ]
                ]
            ]
        ];
        $expected = [
            'and' => [
                'or' => [
                    'foo' => ['not-eq' => 'bar'],
                    'or' => [
                        'bar' => ['!=' => 'baz'],
                        'baz' => [
                            'not-in' => ['bar', 'foo']
                        ]
                    ]
                ]
            ]
        ];
        expect(DataFilter::inverse($filter))->equals($expected);
    }

    public function testFilterByNestedGroups()
    {
        $filter = [
            'or' => [
                [
                    'or' => [
                        'foo' => ['eq' => 'bar'],
                        'bar' => ['contains' => 'bar'],
                    ]
                ],
                [
                    'or' => [
                        'baz' => ['in' => ['bar']],
                        'foo' => ['not-in' => ['baz']],
                    ]
                ],
            ]
        ];
        $data = [
            'foo' => 'bar',
        ];
        expect(DataFilter::filter($data, $filter))->true();

        $data = [
            'foo' => 'baz',
        ];
        expect(DataFilter::filter($data, $filter))->false();

        $data = [
            'bar' => 'bar',
        ];
        expect(DataFilter::filter($data, $filter))->true();

        $filter = [
            'or' => [
                [
                    'or' => [
                        [
                            'foo' => ['eq' => 'bar']
                        ],
                        [
                            'bar' => ['not-contains' => 'bar']
                        ],
                    ]
                ],
                [
                    'or' => [
                        [
                            'baz' => ['in' => ['bar']]
                        ],
                        [
                            'foo' => ['not-in' => ['baz']]
                        ],
                    ]
                ],
            ]
        ];
        $data = [
            'bar' => 'bar',
        ];
        expect(DataFilter::filter($data, $filter))->true();

        $subgroup11 = [
            'and' => [
                [
                    'foo' => [
                        'stripos' => 'bar',
                    ],
                ],
                [
                    'bar' => [
                        'not-stripos' => 'baz',
                    ],
                ],
            ],
        ];
        $subgroup12 = [
            'and' => [
                [
                    'foo' => [
                        'stripos' => 'foo',
                    ],
                ],
                [
                    'bar' => [
                        'not-in' => [
                            'bar',
                        ],
                    ],
                ],
            ],
        ];
        $subgroup1 = [
            'or' => [
                $subgroup11,
                $subgroup12
            ],
        ];
        $subgroup2 = [
            'or' => [
                [
                    'foo' => [
                        'in' => [
                            'foo',
                            'bar',
                        ],
                    ],
                    'bar' => [
                        'in' => [
                            'foo',
                            'foo',
                        ],
                    ],
                ],
            ],
        ];
        $filter = [
            'and' => [
                $subgroup1,
                $subgroup2
            ],
        ];
        $data = [
            'foo' => 'bar',
            'bar' => 'foo'
        ];
        expect(DataFilter::filter($data, $subgroup11))->true();
        expect(DataFilter::filter($data, $subgroup12))->false();
        expect(DataFilter::filter($data, $subgroup1))->true();
        expect(DataFilter::filter($data, $subgroup2))->true();
        expect(DataFilter::filter($data, $filter))->true();

        $data = [
            'foo' => 'bar',
            'bar' => 'baz'
        ];
        expect(DataFilter::filter($data, $subgroup11))->false();
        expect(DataFilter::filter($data, $subgroup12))->false();
        expect(DataFilter::filter($data, $subgroup1))->false();
        expect(DataFilter::filter($data, $subgroup2))->true();
        expect(DataFilter::filter($data, $filter))->false();

        $unbind = [
            'or' => [
                'foo' => [
                    'not-in' => [
                        'bas',
                        'baz',
                    ],
                ],
                'bar' => [
                    'not-in' => [
                        'bas',
                        'foo',
                    ],
                ],
            ],
        ];
        expect(DataFilter::filter($data, $unbind))->true();
        $subgroup1 =  [
            'or' => [
                'foo' => [
                    'in' => [
                        'baz',
                    ],
                ],
                'bar' => [
                    'in' => [
                        'foo',
                    ],
                ],
            ],
        ];
        $subgroup2 = [
            'or' => [
                'foo' => [
                    'not-in' => [
                        'foo',
                    ],
                ],
                'bar' => [
                    'not-in' => [
                        'bar',
                    ],
                ],
            ],
        ];
        $unbind = [
            'or' => [
                $subgroup1,
                $subgroup2
            ],
        ];
        expect(DataFilter::filter($data, $subgroup1))->false();
        expect(DataFilter::filter($data, $subgroup2))->true();
        expect(DataFilter::filter($data, $unbind))->true();
        $unbind = [
            'and' => [
                $subgroup1,
                $subgroup2
            ],
        ];
        expect(DataFilter::filter($data, $unbind))->false();
    }
}
