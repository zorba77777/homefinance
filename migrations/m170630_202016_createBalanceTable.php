<?php

use yii\db\Migration;

class m170630_202016_createBalanceTable extends Migration
{
    public function up()
    {
        $this->createTable(
            'balance',
            [
                'id' => $this->primaryKey(),
                'login' => $this->string(50)->notNull()->unique(),
                'summ' => $this->integer(255),
            ],
            'ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci'
        );
    }

    public function down()
    {
        echo "m170630_202016_createBalanceTable cannot be reverted.\n";

        return false;
    }
}
