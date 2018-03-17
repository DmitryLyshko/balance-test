<?php

use yii\db\Migration;

/**
 * Class m180317_121532_base
 */
class m180317_121532_base extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $columns = [
            'id' => $this->primaryKey(),
            'type_id' => $this->smallInteger(8)
        ];

        $this->createTable('client', $columns);
        $this->alterColumn('client', 'id', $this->smallInteger(11));

        $columns = [
            'id' => $this->primaryKey(),
            'client_id' => $this->smallInteger(11),
            'sum' => $this->smallInteger(8),
        ];
        $this->createTable('balance', $columns);

        $this->addForeignKey(
            'fk_balance',
            'balance',
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
        $this->dropTable('balance');
        $this->dropTable('client');

        echo "m180317_121532_base cannot be reverted.\n";

        return true;
    }
}
