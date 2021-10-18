<?php

namespace app\models;

use Yii;

/**
 * Class ChangeEmails
 * @package app\models
 */
class ChangeEmails extends \yii\db\ActiveRecord
{

    CONST TYPE_ADMIN = 'admin';
    CONST TYPE_HELP = 'help';
    CONST TYPE_NO_REPLY = 'no-reply';

    /**
     * @return string
     */
    public static function tableName()
    {
        return 'change_emails';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'email'], 'required'],
            [['user_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['email'], 'string', 'max' => 200],
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
            'email' => Yii::t('app', 'Новый E-mail'),
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

    public static function emailFrom($type_from = false)
    {
        if ($type_from == self::TYPE_ADMIN) {
            $type_from = \Yii::$app->params['adminEmail'];
        } else if ($type_from == self::TYPE_HELP) {
            $type_from = \Yii::$app->params['helpEmail'];
        } else if ($type_from == self::TYPE_NO_REPLY) {
            $type_from = \Yii::$app->params['no-replyEmail'];
        } else {
            $type_from = \Yii::$app->params['no-replyEmail'];
        }

        return $type_from;
    }
}
