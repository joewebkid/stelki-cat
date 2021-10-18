<?php

use yii\db\Migration;

/**
 * Class m200304_164517_add_table_change_emails
 */
class m200304_164517_add_table_change_emails extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('change_emails', [
            'id' => $this->primaryKey()->comment('Id'),
            'user_id' => $this->integer(11)->notNull()->comment('Id пользователя'),
            'email' => $this->string(200)->notNull()->comment('Новый E-mail'),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP')
        ]);

        $this->addForeignKey(
            'change_email_user_id_fk',  // это "условное имя" ключа
            'change_emails', // это название текущей таблицы
            'user_id', // это имя поля в текущей таблице, которое будет ключом
            'users', // это имя таблицы, с которой хотим связаться
            'id', // это поле таблицы, с которым хотим связаться
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('change_emails');

        $this->dropForeignKey(
            'change_email_user_id_fk',
            'change_emails'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200304_164517_add_table_change_emails cannot be reverted.\n";

        return false;
    }
    */
}
