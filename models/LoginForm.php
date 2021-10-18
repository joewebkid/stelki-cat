<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\validators\EmailValidator;
use app\components\validators\EmailValidatorUniq;
use app\components\validators\PhoneValidatorUniqWithoutUserPhone;
use app\components\validators\PhoneValidator;
use app\components\validators\PhoneExistenceValidator;
use app\components\validators\EmailExistenceValidator;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{

    const SCENARIO_LOGIN = 'login';
    const SCENARIO_REGISTRATION_EMAIL  = 'registration_email';
    const SCENARIO_REGISTRATION_STEP1  = 'registration_step_1';
    const SCENARIO_REGISTRATION_STEP2  = 'registration_step_2';
    const SCENARIO_PASSWORD_RECOVERY_STEP1 = 'recovery_step_1';
    const SCENARIO_PASSWORD_RECOVERY_STEP2 = 'recovery_step_2';
    const SCENARIO_PROFILE_EDIT_PHONE_STEP1 = 'edit_phone_step_1';
    const SCENARIO_PROFILE_EDIT_PHONE_STEP2 = 'edit_phone_step_2';
    const SCENARIO_PROFILE_EDIT_EMAIL = 'edit_email';
    const SCENARIO_PROFILE_EDIT_PASSWORD = 'edit_password';
    const SCENARIO_PROFILE_EDIT_ANY = 'edit_any_params';

    public $login;
    public $phone;
    public $code;
    public $password;
    public $password_old;
    public $email;
    public $email_newsletter;
    public $sms_newsletter;
    public $password_repeat;
    public $rememberMe = true;

    private $_user = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['phone', 'login', 'email'], 'trim'],
            [['phone', 'login', 'password'], 'required', 'except' => [self::SCENARIO_PROFILE_EDIT_PHONE_STEP2, self::SCENARIO_PROFILE_EDIT_PASSWORD]],
            ['email', 'required', 'on' => self::SCENARIO_REGISTRATION_EMAIL],

            [['password_repeat', 'code'], 'required', 'on' => [self::SCENARIO_REGISTRATION_STEP2]],
            [['code'], 'string', 'length' => [5, 6], 'on' => [self::SCENARIO_REGISTRATION_STEP2, self::SCENARIO_PROFILE_EDIT_PHONE_STEP2]],
            ['password', 'compare', 'compareAttribute' => 'password_repeat', 'on' => [self::SCENARIO_PASSWORD_RECOVERY_STEP2,  self::SCENARIO_PROFILE_EDIT_PASSWORD, self::SCENARIO_REGISTRATION_EMAIL]],
            ['phone', PhoneValidator::className(), 'on' => self::SCENARIO_LOGIN],
            ['email', EmailExistenceValidator::className(), 'on' => self::SCENARIO_PASSWORD_RECOVERY_STEP1],

            ['code', 'required', 'on' => self::SCENARIO_PROFILE_EDIT_PHONE_STEP2],

            ['email', 'email', 'on' => [self::SCENARIO_PROFILE_EDIT_EMAIL, self::SCENARIO_PROFILE_EDIT_PHONE_STEP2, self::SCENARIO_REGISTRATION_EMAIL]],

            ['phone', PhoneValidatorUniqWithoutUserPhone::className(), 'on' => [self::SCENARIO_REGISTRATION_STEP1, self::SCENARIO_PROFILE_EDIT_PHONE_STEP2]],
            ['email', EmailValidator::className(), 'on' => self::SCENARIO_PROFILE_EDIT_EMAIL],
            ['email', EmailValidatorUniq::className(), 'on' => [self::SCENARIO_PROFILE_EDIT_EMAIL, self::SCENARIO_REGISTRATION_EMAIL]],
            ['email', 'required', 'on' => self::SCENARIO_PROFILE_EDIT_EMAIL],
            [['password_old', 'password', 'password_repeat'], 'required', 'on' => self::SCENARIO_PROFILE_EDIT_PASSWORD],
//            ['login', 'required', 'on' => self::SCENARIO_PROFILE_EDIT_ANY, self::SCENARIO_REGISTRATION_EMAIL],
            [['email_newsletter', 'sms_newsletter'], 'integer', 'max' => 1, 'on' => self::SCENARIO_PROFILE_EDIT_ANY],
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[static::SCENARIO_LOGIN] = ['email', 'password'];
        $scenarios[static::SCENARIO_REGISTRATION_EMAIL] = ['email', 'password', 'password_repeat', 'login'];
        $scenarios[static::SCENARIO_REGISTRATION_STEP1] = ['phone'];
        $scenarios[static::SCENARIO_REGISTRATION_STEP2] = ['password', 'password_repeat', 'code', 'login'];
        $scenarios[static::SCENARIO_PASSWORD_RECOVERY_STEP1] = ['email'];
        $scenarios[static::SCENARIO_PASSWORD_RECOVERY_STEP2] = ['password', 'password_repeat'];
        $scenarios[static::SCENARIO_PROFILE_EDIT_PHONE_STEP1] = ['phone'];
        $scenarios[static::SCENARIO_PROFILE_EDIT_EMAIL] = ['email'];
        $scenarios[static::SCENARIO_PROFILE_EDIT_ANY] = ['login','email_newsletter', 'sms_newsletter'];

        return $scenarios;
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if($user = $this->getUser()){
            if ($this->validate()) {
                if($user->checkPassword($this->password)){
                    return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
                }
            }else{
                print_r($this->getErrors());
                exit;
            }
        }

        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return Users|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
//            $this->_user = Users::findByPhoneAndPassword($this->phone, $this->password);
            $this->_user = Users::findByEmail($this->email);
        }

        return $this->_user;
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Имя',
            'pwhash' => 'Pwhash',
            'password' => 'Пароль',
            'password_repeat' => 'Повторите пароль',
            'password_old' => 'Установленый пароль',
            'code' => 'Код из SMS',
            'email' => 'E-mail',
            'email_newsletter' => 'E-mail оповещения',
            'sms_newsletter' => 'SMS оповещения',
            'phone' => 'Номер телефона',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'rememberMe' => 'Запомнить меня',
        ];
    }
}
