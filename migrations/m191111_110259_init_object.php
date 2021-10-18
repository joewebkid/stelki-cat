<?php

use yii\db\Migration;

/**
 * Class m191111_110259_init_object
 */
class m191111_110259_init_object extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('objects', [
            'id' => $this->primaryKey(),
            'coord_lat' => $this->string()->comment('Широта'),
            'coord_len' => $this->string()->comment('Долгота'),
            'address' => $this->string()->comment('Улица, корпус, дом'),
            'region' => $this->string()->comment('Регион'),
            'name' => $this->string()->comment('Название'),
            'city' => $this->string()->comment('Город'),
            'district' => $this->string()->comment('Район'),
            'zone' => $this->string()->comment('Округ'),
            'photos' => $this->string()->comment('Фотки в формате "foto1.jpg,photo2.png"'),
            'metro' => $this->text()->comment('Информация о метро (json)'),
            'description' => $this->string()->comment('Описание объекта'),
            'residential_сomplex_id' => $this->string()->comment('ЖК'),
            'area' => $this->string()->comment('Площадь'),
            'security' => $this->string()->comment('Охрана'),
            'price' => $this->string()->comment('Цена'),
            'owner' => $this->integer(2)->comment('Собственник или агенство 0/1'),
            'status' => $this->integer(2)->comment('Статус объекта'),
            'type' => $this->integer(2)->comment('Тип объекта'),
            'user_id' => $this->integer()->comment('Id владельца объекта'),
            'saleType' => $this->integer()->comment('Аренда или продажа'),
            'created_at' => $this->integer()->notNull()->unsigned(),
            'updated_at' => $this->integer()->notNull()->unsigned(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('objects');
    }
}
