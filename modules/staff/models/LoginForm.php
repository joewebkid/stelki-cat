<?php

namespace app\modules\staff\models;

use Yii;
use yii\base\Model;
use app\modules\staff\models\Staff;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $email;
    public $password;
    public $password_confirm;

    private $_user = false;

    const SCENARIO_LOGIN = 'login';
    const SCENARIO_FORGETPASSWORD = 'forgetpassword';
    const SCENARIO_RESTOREPASSWORD = 'restorepassword';
    const SCENARIO_INVITATION = 'invitation';
    const SCENARIO_CREATE = 'create';
    const SCENARIO_SUCCESS = 'success';


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [
                ['password', 'password_confirm'],
                'string', 'min' => 6,
                'message' => 'Необходимо не менее 6 символов.'
            ],
            ['email', 'email'],
            [
                'password_confirm', 'compare',
                'compareAttribute' => 'password',
                'message' => 'Пароли должны сопадать.',
                'on' => [
                    self::SCENARIO_RESTOREPASSWORD,
                    self::SCENARIO_INVITATION,
                ]
            ],
            // username and password are both required
            [
                ['email', 'password'], 'required',
                // 'message' => 'Пароли должны сопадать.',
                'on' => [
                    self::SCENARIO_LOGIN,
                ],
            ],
            [
                ['email'], 'required',
                'on' => [
                    self::SCENARIO_CREATE,
                    self::SCENARIO_FORGETPASSWORD,
                ],
            ],
            [
                ['email'], 'unique',
                'message' => 'Такой емейл уже существует.',
                'on' => [
                    self::SCENARIO_CREATE,
                ],
            ],
            // password is validated by validatePassword()
            [
                'password', 'validatePassword',
                'on' => [
                    self::SCENARIO_LOGIN,
                ],
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => Yii::t('app', 'email'),
            'password' => Yii::t('app', 'password'),
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->checkPassword($this->password)) {

                $user = Staff::findOne(['login' => $this->email, 'status' => Staff::STATUS_DISABLED]);
                if ($user)
                    $this->addError($attribute, 'Ваш аккаунт заблокирован.');
                else
                    $this->addError($attribute, 'E-mail или пароль вееден не верно.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), 3600 * 24 * 30);
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return Staff|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = Staff::auth($this->email, $this->password);
        }

        return $this->_user;
    }
}
