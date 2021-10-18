<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "email_hash".
 *
 * @property int $id Id
 * @property int $user_id Id пользователя
 * @property int $type Тип хеша
 * @property string|null $hash HASH
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Emailhash extends \yii\db\ActiveRecord
{
    const SCENARIO_CHANGE_EMAIL = 'change_email';

    const PASSWORD_RECOVERY = 2;
    const EMAIL_CHANGE = 3;
    const EMAIL_ACTIVE = 4;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'email_hash';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'type'], 'required', 'except' => [self::SCENARIO_CHANGE_EMAIL]],
            [['user_id', 'type'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['hash'], 'string', 'length' => [20, 20]],
            [['hash'], 'required', 'on' => [self::SCENARIO_CHANGE_EMAIL]],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[static::SCENARIO_CHANGE_EMAIL] = ['hash'];

        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
            'user_id' => Yii::t('app', 'Id пользователя'),
            'type' => Yii::t('app', 'Тип хеша'),
            'hash' => Yii::t('app', 'HASH'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    public static function generate()
    {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return self::generate_string($permitted_chars, 20);
    }

    public static function generate_string($input, $strength = 20)
    {
        $input_length = strlen($input);
        $random_string = '';
        for ($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }

        return $random_string;
    }
}
