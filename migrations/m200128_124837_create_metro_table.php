<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%metro}}`.
 */
class m200128_124837_create_metro_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('metro', [
            'id' => $this->primaryKey()->comment('Id'),
            'object_id' => $this->integer(11)->unsigned()->notNull()->comment('Id объекта'),
            'metro_id' => $this->integer(11)->unsigned()->notNull()->comment('Id метро'),
            'metro_distance' => $this->smallInteger(5)->unsigned()->comment('Расстояние до метро в метрах'),
            'metro_time' => $this->tinyInteger(3)->unsigned()->comment('Время до метро в минутах'),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('metro');
    }
}
