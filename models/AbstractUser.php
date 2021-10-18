<?php namespace app\models;

use app\common\interfaces\UserInterface;
use app\models\TempToken;
use Ramsey\Uuid\Uuid;
use yii\base\Exception;
use yii\base\InvalidValueException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\IdentityInterface;

/**
 * Class AbstractUser
 * @package app\models
 *
 * @property string $id
 * @property string $login
 * @property string $pwhash
 * @property string $authKey
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property TempToken[] $tempTokens
 */
abstract class AbstractUser extends ActiveRecord implements IdentityInterface, UserInterface
{
    const STATUS_DISABLED = 0;
    const STATUS_ENABLED = 1;
    const STATUS_TESTER = 9;

    const SCENARIO_LOGIN = 'login';
    const SCENARIO_FORGETPASSWORD = 'forgetpassword';
    const SCENARIO_RESTOREPASSWORD = 'restorepassword';

    const DEFAULT_AVATAR = '/images/img-placeholder.jpg';


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [TimestampBehavior::class];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['id', 'default', 'value' => Uuid::uuid1()->toString()],
//            ['created_at', 'default', 'value' => time()],
//            [['id', 'login', 'created_at'], 'required'],
//            [['id', 'login'], 'unique'],
            ['login', 'filter', 'filter' => 'strtolower'],
            ['login', 'email'],
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return ArrayHelper::merge(parent::scenarios(),
            [
                self::SCENARIO_FORGETPASSWORD => ['login'],
                self::SCENARIO_RESTOREPASSWORD => ['password', 'password_confirm'],
            ]);
    }

    /**
     * @return string
     */
    public function getLogin()
    {
        return $this->getAttribute('login');
    }

    /**
     * @return array
     */
    private static function getStatusMap()
    {
        return [
            static::STATUS_DISABLED => \Yii::t('app', 'Disabled'),
            static::STATUS_ENABLED => \Yii::t('app', 'Enabled')
        ];
    }

    /**
     * @return string
     */
    public function getStatusName()
    {
        return static::getStatusMap()[$this->status] ?? \Yii::t('app', 'Unknown');
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->getAttribute('id');
    }

    /**
     * @param int|string $id
     * @return null|static
     */
    public static function findIdentity($id)
    {
        $condition = ['and',
            ['id' => $id],
            // ['!=', 'status', static::STATUS_DISABLED]
        ];

        return static::find()
            ->where($condition)
            ->limit(1)
            ->one();
    }

    /**
     * @param mixed $token
     * @param null $type
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    /**
     * @param string $algo
     * @param bool $raw
     * @return string
     */
    private function getSignKey(string $algo, $raw = false)
    {
        return hash_hmac($algo, $this->getLogin(), $this->getAttribute('pwhash'), $raw);
    }

    /**
     * @return string
     */
    public function getAuthKey()
    {
        return $this->getSignKey('sha1', false);
    }

    /**
     * @param string $authKey
     * @return bool
     */
    public function validateAuthKey($authKey)
    {
        return \Yii::$app->security
            ->compareString($this->authKey, $authKey);
    }

    /**
     * @param string|null $password
     * @return $this
     * @throws Exception
     */
    public function setPassword(string $password = null)
    {
        if (!is_null($password)) {
            $password = \Yii::$app->security->generatePasswordHash($password);
        }

        $this->setAttribute('pwhash', $password);

        return $this;
    }

    /**
     * @param string $password
     * @return bool
     */
    public function checkPassword(string $password)
    {
        if (!empty($password) && !empty($this->pwhash)) {
            return \Yii::$app->security->validatePassword($password, $this->pwhash);
        }

        return false;
    }

    /**
     * @return ActiveQuery
     */
    public function getTempTokens()
    {
        return $this->hasMany(TempToken::class, ['item_id' => 'id'])
            ->where(['model_class' => static::class])
            ->inverseOf('owner');
    }

    /**
     * @param string $type
     * @param string|null $data
     * @param int|null $ttl
     * @return TempToken
     * @throws Exception
     */
    public function addToken(string $type = TempToken::TYPE_PWRESET, $data = null, int $ttl = null)
    {
        if (is_array($data) || is_object($data)) {
            $data = Json::encode($data);
        }

        $token = new TempToken([
            'model_class' => static::class,
            'item_id' => $this->id,
            'type' => $type,
            'data_raw' => $data,
            'ttl' => $ttl,
        ]);

        if (!$token->save()) {
            throw new Exception("Can't save a token");
        }

        $token->refresh();

        return $token;
    }

    /**
     * @param string $login
     * @return array|null|static
     */
    public static function fetchActive(string $login)
    {
        $condition = ['and',
            ['login' => $login],
            ['!=', 'status', static::STATUS_DISABLED]];

        return static::find()
            ->where($condition)
            ->limit(1)
            ->one();
    }

    /**
     * @param string $login
     * @param string|null $password
     * @return null|static
     */
    public static function auth(string $login, string $password = null)
    {
        if (!$user = static::fetchActive($login)) {
            \Yii::warning("User not found!", __METHOD__);
            return null;
        }

        if (!empty($user->pwhash)) {
            \Yii::info("Staff person protected by password");
            if (!$user->checkPassword($password)) {
                \Yii::error("Access denied");
                return null;
            }
        }

        return $user;
    }

    /**
     * @param bool $newToken
     * @param int|null $ttl
     * @return string
     * @throws Exception
     */
    public function resetPassword(bool $newToken = true, int $ttl = null): string
    {
        $token = $this->addToken(TempToken::TYPE_PWRESET, null, $ttl);

        return Url::toRoute(['user/password-set', 'token' => $token->value], true);
    }

    /**
     * @param string $email
     * @param bool $newToken
     * @param int|null $ttl
     * @return string
     * @throws Exception
     */
    public function changeLogin(string $email, bool $newToken = true, int $ttl = null): string
    {
        $token = $this->addToken(TempToken::TYPE_EMAILRESET, $email, $ttl);

        return Url::toRoute(['user/email-change', 'token' => $token->value], true);
    }

    /**
     * @param string|null $password
     * @return null|string
     */
    public function getActivationUrl(string $keyName = 'token', string $password = null)
    {
        if (!$this->isNewRecord) {
            return null;
        }

        $model = ['class' => static::class]
            + $this->toArray(['id', 'login', 'pwhash', 'status', 'created_at']);

        $dataString = \Yii::$app->security->encryptByPassword(bzcompress(serialize($model)),
            $password ?? \Yii::$app->request->cookieValidationKey);

        return Url::toRoute(['user/activate', $keyName => base64_encode($dataString)], true);
    }

    /**
     * @param string $string
     * @param string|null $password
     * @return static
     * @throws \Throwable
     */
    public static function decode(string $data, string $password = null)
    {
        $user = null;
        if (!$data = base64_decode($data)) {
            throw new InvalidValueException(\Yii::t('app', "Can't decode data from string"));
        } elseif (!$data = \Yii::$app->security->decryptByPassword($data, $password ?? \Yii::$app->request->cookieValidationKey)) {
            throw new InvalidValueException(\Yii::t('app', "Can't decrypt data"));
        } elseif (!$data = bzdecompress($data)) {
            throw new InvalidValueException(\Yii::t('app', "Can't unpack data"));
        }

        if (!is_a(($user = \Yii::createObject(unserialize($data))), static::class, false)) {
            throw new InvalidValueException(\Yii::t('app', "Can't unserialize object or object is not instance of {class}",
                ['class' => static::class]));
        }

        return $user;
    }
}
