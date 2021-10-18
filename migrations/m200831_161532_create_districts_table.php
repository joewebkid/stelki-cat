<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%district}}`.
 */
class m200831_161532_create_districts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%districts}}', [
            'id' => $this->primaryKey()->comment('Id'),
            'name' => $this->string(100)->unsigned()->comment('Название района'),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%districts}}');
    }
}
