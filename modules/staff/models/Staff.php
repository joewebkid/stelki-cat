<?php

namespace app\modules\staff\models;

use app\models\AbstractUser;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

/**
 * Class Staff
 * @package app\models
 *
 * @property Staff $referrer
 * @property Staff[] $followers
 */
class Staff extends AbstractUser
{
    const STATUS_INVITATION_REJECTED = 3;
    const STATUS_WAIT_CONFIRMATION = 4;

//    /**
//     * @inheritdoc
//     */
//    public function rules()
//    {
//        return ArrayHelper::merge(parent::rules(), [
//            ['invited_by', 'exist', 'targetAttribute' => 'id'],
//        ]);
//    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'login' => \Yii::t('app', 'E-Mail'),
            'status' => \Yii::t('app', 'Status'),
            'created_at' => \Yii::t('app', 'Created at'),
            'updated_at' => \Yii::t('app', 'Updated at'),
        ];
    }

    public function getReturnUrl() {
        return "/admin";
    }
    /**
     * @return ActiveQuery
     */
    public function getReferrer()
    {
        return $this->hasOne(static::class, ['id' => 'invited_by']);
    }

    /**
     * @return ActiveQuery
     */
    public function getFollowers()
    {
        return $this->hasMany(static::class, ['invited_by' => 'id'])
            ->inverseOf('referer');
    }

    public function getAvatarPhotoUrl() {
        if ( !empty($this->avatar) )
            return $this->avatar;

        return parent::DEFAULT_AVATAR;
    }
}
