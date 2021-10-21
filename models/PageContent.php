<?php

namespace app\models;

use \yii\db\ActiveRecord;
use \yii\behaviors\TimestampBehavior;
use \yii\db\Expression;

class PageContent extends \yii\db\ActiveRecord
{
    const PAGE_TYPE_MAIN = 'main';
    const PAGE_TYPE_TECHNOLOGY = 'technology';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'page_content';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'name' => 'Название блока',
            'value' => 'Наполнение блока',
            'created_at' => 'Создано',
            'updated_at' => 'Изменено',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value', 'created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 100]
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()')
            ],
        ];
    }
}

?>