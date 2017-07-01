<?php

use yii\db\Migration;

class m170630_195529_createTransactionsTable extends Migration
{
    public function up()
    {
        $this->createTable(
            'transactions',
            [
                'id' => $this->primaryKey(),
                'login' => $this->string(50)->notNull(),
                'date' => $this->timestamp(),
                'summ' => $this->integer(255),
                'category' => $this->string(50),
                'type' => $this->string(50)
            ],
            'ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci'
        );
    }

    public function down()
    {
        echo "m170630_195529_createTransactionsTable cannot be reverted.\n";

        return false;
    }


}
