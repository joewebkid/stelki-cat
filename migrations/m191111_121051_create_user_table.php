<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m191111_121051_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'login' => $this->string()->notNull()->unique(),
            'pwhash' => $this->string(),
            'phone' => $this->string(20),
            'created_at' => $this->integer()->notNull()->unsigned(),
            'updated_at' => $this->integer()->notNull()->unsigned(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('users');
    }
}
