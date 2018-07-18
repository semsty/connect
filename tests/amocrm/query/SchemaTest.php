<?php

namespace connect\crm\tests\amocrm\query;

use connect\crm\amocrm\Service;
use connect\crm\tests\amocrm\TestCase;

class SchemaTest extends TestCase
{
    public $response = [
        'custom_fields' => [
            'leads' => [
                [
                    'id' => '315969',
                    'name' => 'Ссылка',
                    'code' => 'url',
                    'multiple' => 'N',
                    'type_id' => '1',
                    'disabled' => '0',
                    'sort' => 509
                ]
            ]
        ]
    ];

    public function testSystemFieldsConstraints()
    {
        $service = new Service();
        $constraints = $service->schema->getFieldConstraints('lead.name');
        expect($constraints)->equals([
            'type' => 'string',
            'required' => true
        ]);
        expect($service->schema->isFieldRequired('lead.name'))->true();
        expect($service->schema->getFieldsType('lead.name'))->equals('string');
    }

    public function testCustomFieldsConstraints()
    {
        $service = new Service();
        $service->schema->info = $this->response;
        $expected = $this->response['custom_fields']['leads'][0];
        $expected['type'] = 'text';
        $expected['name'] = 'ссылка';
        $constraints = $service->schema->getFieldConstraints('lead.315969');
        expect($constraints)->equals($expected);
        $constraints = $service->schema->getFieldConstraints('lead.url');
        expect($constraints)->equals($expected);
        $constraints = $service->schema->getFieldConstraints('lead.ссылка');
        expect($constraints)->equals($expected);
        expect($service->schema->isFieldRequired('lead.url'))->null();
        expect($service->schema->getFieldsType('lead.url'))->equals('text');
    }

    public function testEnumerationConstraints()
    {
        $service = new Service();
        $constraints = $service->schema->getFieldConstraints('task.task_type');
        expect($constraints)->equals([
            'type' => 'integer',
            'required' => true,
            'enums' => [
                1 => 'call',
                2 => 'meeting',
                3 => 'write-mail',
            ]
        ]);
    }
}