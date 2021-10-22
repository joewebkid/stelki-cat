<?php

use yii\db\Migration;

/**
 * Class m211021_130421_add_bids_table
 */
class m211021_130421_add_bids_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%bids}}', [
            'id' => $this->primaryKey()->comment('Id'),
            'name' => $this->string(100)->comment('Имя'),
            'phone' => $this->string(15)->comment('Телефон'),
            'email' => $this->string(200)->comment('Email'),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211021_130421_add_bids_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211021_130421_add_bids_table cannot be reverted.\n";

        return false;
    }
    */
}
