<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "change_phones".
 *
 * @property int $id Id
 * @property int $user_id Id пользователя
 * @property string $phone Новый номер
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Users $user
 */
class ChangePhones extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'change_phones';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'phone'], 'required'],
            [['user_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['phone'], 'string', 'max' => 20],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
            'user_id' => Yii::t('app', 'Id пользователя'),
            'phone' => Yii::t('app', 'Новый номер'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}
