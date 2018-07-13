<?php

namespace tests\base;

use semsty\connect\base\helpers\ArrayHelper;
use semsty\connect\Settings;
use yii\base\InvalidConfigException;

class IdentifiersTest extends TestCase
{
    public function testCheckServices()
    {
        $services = [];
        foreach (Settings::getServices(false) as $service_name) {
            expect(ArrayHelper::isIn($service_name::ID, $services))->false();
            $services[] = $service_name::ID;
        }
    }

    public function testCheckServiceOperations()
    {
        /*$operations_ids = [];
        $operations_names = [];
        foreach (Settings::getServices() as $service_id => $service_name) {
            foreach ($service_name::getOperations() as $name => $operation) {
                if (is_array($operation)) {
                    $operation = $operation[0];
                }
                $current = $operation::className();
                $check = ArrayHelper::getValue($operations_ids, $operation::OPERATION_ID);
                if ($check) {
                    throw new InvalidConfigException("$current: Operation with ID " . $operation::OPERATION_ID . " already exists: $check");
                }
                expect($check)->null();
                $check = ArrayHelper::getValue(ArrayHelper::getValue($operations_names, $service_id, []), $operation::NAME);
                if ($check) {
                    throw new InvalidConfigException("$current: Operation with name " . $operation::NAME . " already exists: $check");
                }
                expect($check)->null();
                $operations_ids[$operation::OPERATION_ID] = $operation::className();
                $operations_names[$service_id][$operation::NAME] = $operation::className();
            }
        }*/
    }

    public function testCheckServiceActions()
    {
        $actions_ids = [];
        $actions_names = [];
        foreach (Settings::getServices() as $service_id => $service_name) {
            foreach ($service_name::getActions(true, true) as $name => $action) {
                if (is_array($action)) {
                    $action = $action[0];
                }
                $current = $action::className();
                $check = ArrayHelper::getValue(ArrayHelper::getValue($actions_ids, $service_id, []), $action::ID);
                if ($check && ($current != $check)) {
                    throw new InvalidConfigException("$current: Action with ID " . $action::ACTION_ID . " already exists: $check");
                }
                $check = ArrayHelper::getValue(ArrayHelper::getValue($actions_names, $service_id, []), $action::NAME);
                if ($check && ($current != $check)) {
                    throw new InvalidConfigException("$current: Action with name " . $action::NAME . " already exists: $check");
                }
                $actions_ids[$service_id][$action::ID] = $current;
                $actions_names[$service_id][$action::NAME] = $current;
            }
        }
    }
}
