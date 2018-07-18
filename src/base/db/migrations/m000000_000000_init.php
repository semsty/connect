<?php

namespace connect\crm\base\db\migrations;

use yii\db\Migration;

class m000000_000000_init extends Migration
{
    public function up()
    {
        $this->createTable('{{%profile}}', [
            'id' => $this->primaryKey(),
            'title' => $this->text(),
            'service_id' => $this->integer()->notNull(),
            'config_json' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
        $this->createTable('{{%session}}', [
            'id' => $this->bigPrimaryKey(),
            'service_id' => $this->integer(),
            'profile_id' => $this->integer(),
            'is_active' => $this->boolean(),
            'config_json' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
        $this->createTable('{{%operation}}', [
            'id' => $this->bigPrimaryKey(),
            'type_id' => $this->integer(),
            'status_id' => $this->integer(),
            'config_json' => $this->text(),
            'executing_time' => $this->float(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
        $this->createTable('{{%external_record}}', [
            'id' => $this->bigPrimaryKey(),
            'profile_id' => $this->integer()->notNull(),
            'external_id' => $this->string()->notNull(),
            'type' => $this->string()->notNull(),
            'extra_attributes' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
        $this->createTable('{{%external_reference}}', [
            'id' => $this->bigPrimaryKey(),
            'external_id_1' => $this->string()->notNull(),
            'external_id_2' => $this->string()->notNull()
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%profile}}');
        $this->dropTable('{{%session}}');
        $this->dropTable('{{%operation}}');
        $this->dropTable('{{%external_record}}');
        $this->dropTable('{{%external_reference}}');
    }
}
