<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%messages}}`.
 */
class m200205_053104_create_messages_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('messages', [
            'id' => $this->primaryKey()->comment('Id'),
            'user_id_from' => $this->integer(11)->unsigned()->notNull()->comment('Id от кого пользователя'),
            'user_id_to' => $this->integer(11)->unsigned()->notNull()->comment('Id кому пользователя'),
            'type' => $this->smallInteger(5)->unsigned()->notNull()->comment('Тип сообщения'),
            'text' => $this->text()->unsigned()->comment('Текст сообщения'),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('messages');
    }
}
