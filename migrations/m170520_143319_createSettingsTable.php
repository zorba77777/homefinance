<?php

use yii\db\Migration;

class m170520_143319_createSettingsTable extends Migration
{
    public function up()
    {
        $this->createTable(
            'settings',
            [
                'id' => 'pk',
                'group' => $this->string()->notNull(),
                'data' => 'text'
            ],
            'ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci'
        );
    }

    public function down()
    {
        echo "m170520_143319_createSettingsTable cannot be reverted.\n";

        return false;
    }
}
