<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Smshash".
 *
 * @property int $id Id
 * @property int $user_id Id пользователя
 * @property int $type Тип хеша
 * @property int $hash HASH
 * @property string $created_at
 * @property string $updated_at
 */
class Smshash extends \yii\db\ActiveRecord
{
    const NEW_USER = 1;
    const PASSWORD_RECOVERY = 2;
    const PHONE_CHANGE = 3;

    public static function tableName()
    {
        return 'sms_hash';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'type', 'hash'], 'required'],
            [['user_id', 'type'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'user_id' => 'Id пользователя',
            'type' => 'Тип хеша',
            'hash' => 'HASH',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public static function generate()
    {
//        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $permitted_chars = '0123456789';
        return self::generate_string($permitted_chars, 5);
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
