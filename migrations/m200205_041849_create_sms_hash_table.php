<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%sms_hash}}`.
 */
class m200205_041849_create_sms_hash_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('sms_hash', [
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
        $this->dropTable('sms_hash');
    }
}
