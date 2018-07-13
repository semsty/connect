<?php

namespace semsty\connect\base\db\migrations;

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
    }

    public function down()
    {
        $this->dropTable('{{%profile}}');
        $this->dropTable('{{%session}}');
        $this->dropTable('{{%operation}}');
    }
}
