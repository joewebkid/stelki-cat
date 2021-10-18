<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%email_hash}}`.
 */
class m200320_132637_create_email_hash_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('email_hash', [
            'id' => $this->primaryKey()->comment('Id'),
            'user_id' => $this->integer(11)->unsigned()->notNull()->comment('Id пользователя'),
            'type' => $this->smallInteger(5)->unsigned()->notNull()->comment('Тип хеша'),
            'hash' => $this->string(20)->unsigned()->comment('HASH'),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('email_hash');
    }
}
