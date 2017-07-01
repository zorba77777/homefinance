<?php

use yii\db\Migration;

class m170630_200749_createCategoriesTable extends Migration
{
    public function up()
    {
        $this->createTable(
            'categories',
            [
                'id' => $this->primaryKey(),
                'login' => $this->string(50)->notNull(),
                'category' => $this->string(200),
                'typeOfCategory' => $this->string(50),
                'parent_category' => $this->string(50)->defaultValue('none'),
                'has_child' => $this->string(50)->defaultValue('no'),
                'position' => $this->integer(11)->defaultValue(0)
            ],
            'ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci'
        );
    }

    public function down()
    {
        echo "m170630_200749_createCategoriesTable cannot be reverted.\n";

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
