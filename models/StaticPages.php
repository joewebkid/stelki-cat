<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "static_pages".
 *
 * @property int $id Id
 * @property string $text Текст
 * @property string $title Заголовок
 * @property string $url Ссылка
 * @property string $created_at
 * @property string $updated_at
 */
class StaticPages extends \yii\db\ActiveRecord
{
    const POSITION_HEAD = 1;
    const POSITION_HEAD_LABEL = 'Верхнее меню';

    const POSITION_FOOTER = 2;
    const POSITION_FOOTER_LABEL = 'Футер';

    const ACTIVE_YES = 1;
    const ACTIVE_YES_LABEL = 'Активно';

    const ACTIVE_NO = 0;
    const ACTIVE_NO_LABEL = 'Не активно';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'static_pages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text', 'title', 'url', 'position', 'active'], 'required'],
            [['text'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'url'], 'string', 'max' => 200],
            [['position', 'active', 'priority'], 'integer'],
            ['position', 'in', 'range' => [self::POSITION_HEAD, self::POSITION_FOOTER], 'allowArray' => true]
        ];
    }

    public function getPositionArray()
    {
        return [
            StaticPages::POSITION_HEAD => StaticPages::POSITION_HEAD_LABEL,
            StaticPages::POSITION_FOOTER => StaticPages::POSITION_FOOTER_LABEL,
        ];
    }

    public function getPositionName()
    {
        $positions = self::getPositionArray();

        if (isset($positions[$this->position])) {
            return $positions[$this->position];
        } else {
            return '-';
        }
    }

    public function getActiveArray()
    {
        return [
            StaticPages::ACTIVE_YES => StaticPages::ACTIVE_YES_LABEL,
            StaticPages::ACTIVE_NO => StaticPages::ACTIVE_NO_LABEL,
        ];
    }

    public function getActiveName()
    {
        $active = self::getActiveArray();

        if (isset($active[$this->active])) {
            return $active[$this->active];
        } else {
            return StaticPages::ACTIVE_NO_LABEL;
        }
    }

    public static function priorityArray()
    {
        return [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10];
    }

    public static function headMenu()
    {
        $headMenu = [];
        foreach (StaticPages::find()->where(['AND', ['=', 'position', StaticPages::POSITION_HEAD], ['=', 'active', StaticPages::ACTIVE_YES]])->all() as $list) {
            $headMenu['/page/'.$list->url] = $list->title;
        }

        return $headMenu;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'text' => 'Текст',
            'title' => 'Заголовок',
            'url' => 'Ссылка',
            'position' => 'Позиция отображения',
            'active' => 'Активность',
            'priority' => 'Приоритет',
            'created_at' => 'Создано',
            'updated_at' => 'Updated At',
        ];
    }
}
