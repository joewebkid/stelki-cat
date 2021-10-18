<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%residential_complexes}}`.
 */
class m200830_150157_create_residential_complexes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%residential_complexes}}', [
            'id' => $this->primaryKey()->comment('Id'),
            'name' => $this->string(100)->unsigned()->comment('Название ЖК'),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%residential_complexes}}');
    }
}
