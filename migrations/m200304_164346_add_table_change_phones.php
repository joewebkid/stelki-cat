<?php

use yii\db\Migration;

/**
 * Class m200304_164346_add_table_change_phones
 */
class m200304_164346_add_table_change_phones extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('change_phones', [
            'id' => $this->primaryKey()->comment('Id'),
            'user_id' => $this->integer(11)->notNull()->comment('Id пользователя'),
            'phone' => $this->string(20)->notNull()->comment('Новый номер'),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP')
        ]);

        $this->addForeignKey(
            'change_phone_user_id_fk',  // это "условное имя" ключа
            'change_phones', // это название текущей таблицы
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
        $this->dropTable('change_phones');

        $this->dropForeignKey(
            'change_phone_user_id_fk',
            'change_phones'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200304_164346_add_table_change_phones cannot be reverted.\n";

        return false;
    }
    */
}
