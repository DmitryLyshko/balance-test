<?php

use yii\db\Migration;

/**
 * Class m180317_150840_costs
 */
class m180317_150840_costs extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $columns = [
            'id' => $this->primaryKey(),
            'client_id' => $this->smallInteger(11),
            'date_from' => $this->dateTime()->notNull(),
            'date_to' => $this->dateTime()->notNull(),
            'sum' => $this->integer(8)->notNull()
        ];

        $this->createTable('costs', $columns);

        $this->addForeignKey(
            'fk_costs_client_id',
            'costs',
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
        $this->dropTable('costs');

        echo "m180317_150840_costs cannot be reverted.\n";

        return true;
    }
}
