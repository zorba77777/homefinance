<?php

use yii\db\Migration;

class m170630_185744_createUsersTable extends Migration
{
    public function up()
    {
        $this->createTable(
            'users',
            [
                'id' => $this->primaryKey(),
                'login' => $this->string(50)->notNull()->unique(),
                'password' => $this->string(200)->notNull(),
                'name' => $this->string(50),
                'surname' => $this->string(50),
                'city' => $this->string(50),
                'role' => $this->string(50),
                'email' => $this->string(50)->notNull()->unique(),
                'subscribed' => $this->smallInteger(1)->defaultValue(0),
                'vk_id' => $this->integer(11)->defaultValue(0)
            ],
            'ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci'
        );
    }

    public function down()
    {
        echo "m170630_185744_createUsersTable cannot be reverted.\n";

        return false;
    }

}
