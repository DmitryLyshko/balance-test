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
            'type_id' => $this->smallInteger(2),
            'date_from' => $this->dateTime()->notNull(),
            'date_to' => $this->dateTime()->notNull(),
            'sum' => $this->integer(8)->notNull()
        ];

        $this->createTable('bill', $columns);
        $this->alterColumn('bill', 'id', $this->smallInteger(11) . 'NOT NULL AUTO_INCREMENT');

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
