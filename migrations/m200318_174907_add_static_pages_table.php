<?php

use yii\db\Migration;

/**
 * Class m200318_174907_add_static_pages_table
 */
class m200318_174907_add_static_pages_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('static_pages', [
            'id' => $this->primaryKey()->comment('Id'),
            'text' => $this->text()->notNull()->comment('Текст'),
            'title' => $this->string(200)->notNull()->comment('Заголовок'),
            'url' => $this->string(200)->notNull()->comment('Ссылка'),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {        
        $this->dropTable('static_pages');
    }
}
