<?php

use yii\db\Migration;

/**
 * Class m180317_150712_bill
 */
class m180317_150712_bill extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $columns = [
            'id' => $this->primaryKey(),
            'client_id' => $this->smallInteger(11),
            'type_id' => $this->smallInteger(8),
            'date_from' => $this->smallInteger(15),
            'date_to' => $this->smallInteger(15),
            'sum' => $this->integer(8)
        ];

        $this->createTable('bill', $columns);

        $this->addForeignKey(
            'fk_bill_client_id',
            'bill',
            'client_id',
            'client',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('bill');

        echo "m180317_150712_bill cannot be reverted.\n";

        return true;
    }
}
