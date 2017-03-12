<?php

use yii\db\cubrid\Schema;
use yii\db\Migration;

class m170312_192441_table_xls extends Migration
{
    public function up()
    {
        $this->createTable('xls_data', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING,
            'parent_id' => Schema::TYPE_INTEGER,
            'date' => Schema::TYPE_DATE
        ]);
    }

    public function down()
    {
        echo "m170312_192441_table_xls cannot be reverted.\n";
        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
