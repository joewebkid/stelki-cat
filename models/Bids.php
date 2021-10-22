<?php

namespace app\models;

use \yii\db\ActiveRecord;

class Bids extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bids';
    }

    public function rules()
    {
        return [
            [['name', 'phone', 'email'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'name' => 'Имя',
            'phone' => 'Телефон',
            'email' => 'Электронная почта',
            'created_at' => 'Создано'
        ];
    }
}