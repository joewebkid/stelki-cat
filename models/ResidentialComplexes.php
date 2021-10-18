<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "residential_complexes".
 *
 * @property int $id Id
 * @property string|null $name Название ЖК
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class ResidentialComplexes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'residential_complexes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
            'name' => Yii::t('app', 'Название ЖК'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
