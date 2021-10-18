<?php

namespace app\models;

use app\components\informing\Email;
use app\models\Emailhash;
use app\models\Messages;
use yii\behaviors\TimestampBehavior;

use app\models\AbstractUser;
use app\models\Objects;
use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $home_car_wash_id
 * @property string email
 * @property string $login
 * @property string $pwhash
 * @property string $phone
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Records[] $records
 * @property Roles[] $roles
 * @property CarWashes $homeCarWash
 */
class Users extends AbstractUser
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    public function behaviors()
    {
        return [\yii\behaviors\TimestampBehavior::class];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['login', 'pwhash'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'E-mail',
            'pwhash' => 'Pwhash',
            'phone' => 'Номер телефона',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getIsEmailAcitve()
    {
       if($this->hasOne(Emailhash::className(), ['user_id' => 'id'])->where(['=', 'type', Emailhash::EMAIL_ACTIVE])->one()){
           return false;
       }else{
           return true;
       }
    }

    public static function findByPhoneAndPassword($phone)
    {
        return Users::find()->where(['=', 'phone', $phone])->one();
    }

    public static function findByEmail($email)
    {
        return Users::find()->where(['=', 'email', $email])->one();
    }

    public function getUsername()
    {
        return $this->phone;
    }

    // public function getLogin()
    // {
    //     return $this->login??$this->phone;
    // }

    public function isOwner($id)
    {
        $object = Objects::findOne($id);
        return $object->user_id == Yii::$app->user->id;
    }

    public function getCountNewMessages(){
        $result = Messages::find()->select('COUNT(*) AS id')->where(['AND', ['=', 'user_id_to', $this->id], ['=', 'type', 0]])->one();
        return $result->id;
    }

    // /**
    //  * @return \yii\db\ActiveQuery
    //  */
    // public function getRecords()
    // {
    //     return $this->hasMany(\app\models\carWash\Records::className(), ['users_id' => 'id']);
    // }
}
