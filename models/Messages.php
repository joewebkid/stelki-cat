<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "messages".
 *
 * @property int $id Id
 * @property int $user_id_from Id от кого пользователя
 * @property int $user_id_to Id кому пользователя
 * @property int $type Тип сообщения
 * @property string $text Текст сообщения
 * @property string $created_at
 * @property string $updated_at
 */
class Messages extends \yii\db\ActiveRecord
{
    const SCENARIO_NEW = 'new-message';

    const TYPE_NOT_READ = 0;
    const TYPE_READ = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'messages';
    }

    public function getToUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id_to']);
    }

    public function getFromUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id_from']);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text'], 'string'],
            [['text'], 'trim'],
            [['user_id_to', 'text'], 'required', 'on' => self::SCENARIO_NEW],
            [['user_id_to', 'type'], 'integer', 'on' => self::SCENARIO_NEW],
            [['user_id_from'], 'integer', 'on' => [self::SCENARIO_NEW]],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[static::SCENARIO_NEW] = ['text', 'user_id_to'];

        return $scenarios;
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'user_id_from' => 'Id от кого пользователя',
            'user_id_to' => 'Id кому пользователя',
            'type' => 'Тип сообщения',
            'text' => 'Текст сообщения',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public static function findAllChatsWithUser($user_id)
    {
        $chats = [];
        foreach (self::find()->where(['=', 'user_id_from', $user_id])->orderBy(['created_at' => SORT_DESC])
                     ->groupBy(['user_id_to'])->all() as $from) {
            $chats[$from->user_id_to] = [
                'id' => $from->user_id_to,
                'login' => $from->toUser->login,
                'email' => $from->toUser->email,
                'type' => $from->type,
                'created_at' => strtotime($from->created_at)
            ];
        }

        foreach ($zz = self::find()->where(['=', 'user_id_to', $user_id])->orderBy(['created_at' => SORT_DESC])
                     ->groupBy(['user_id_from'])->all() as $to) {
            $pre = [
                'id' => $to->user_id_from,
                'login' => $to->fromUser->login,
                'email' => $to->fromUser->email,
                'type' => $to->type,
                'created_at' => strtotime($to->created_at)
            ];

            if (isset($chats[$to->user_id_from])) {
                if ($pre['created_at'] > $chats[$to->user_id_from]['created_at']) {
                    $chats[$to->user_id_from] = $pre;
                }
            } else {
                $chats[$to->user_id_from] = $pre;
            }
        }

        foreach($chats as $chatId => $chatValue){
            $chats[$chatId]['new'] = self::countNew($chatValue['id'], $user_id);
        }

        return $chats;
    }

    public function countNotReadMessages($user_id_from, $user_id_to)
    {
        if(!$user_id_from || !$user_id_to){
            return 0;
        }

        $count = self::find()->where(['and', ['=', 'user_id_from', $user_id_from], ['=', 'user_id_from', $user_id_to]])->orderBy(['created_at' => SORT_DESC])
            ->groupBy(['user_id_to'])->count();

        echo $count;
    }

    public static function messagesWithUsers($user1, $user2)
    {
        if (!$user1 || !$user2) {
            return false;
        }

        $messages = self::find()
            ->where(['and', ['=', 'user_id_to', $user1], ['=', 'user_id_from', $user2]])
            ->orWhere(['and', ['=', 'user_id_to', $user2], ['=', 'user_id_from', $user1]])
            ->orderBy(['created_at' => SORT_ASC])
            ->all();

        return $messages;
    }

    public static function findHelpChatWithUser($user1)
    {
        if (!$user1) {
            return false;
        }

        $messages = self::find()
            ->where(['and', ['=', 'user_id_to', $user1], ['=', 'user_id_from', 0]])
            ->orWhere(['and', ['=', 'user_id_to', 0], ['=', 'user_id_from', $user1]])
            ->orderBy(['created_at' => SORT_ASC])
            ->all();

        return $messages;
    }

    public static function setRead($from, $to)
    {
        self::updateAll(['type' => self::TYPE_READ], ['AND', ['=', 'user_id_from', $from], ['=', 'user_id_to', $to]]);
    }

    public function countNew($from, $to){
        $result = self::find()->select('COUNT(*) AS id')->where(['AND', ['=', 'user_id_to', $to], ['=', 'user_id_from', $from], ['=', 'type', 0]])->one();
        return $result->id;
    }
}
