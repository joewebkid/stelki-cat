<?php

namespace app\models;

use Yii;
use yii\base\Model;

class HelpForm extends Model
{
    const SCENARIO_NEW = 'new-message';

    public $text;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text'], 'string', 'on' => [self::SCENARIO_NEW]],
            [['text'], 'trim', 'on' => [self::SCENARIO_NEW]],
            [['text'], 'required', 'on' => [self::SCENARIO_NEW]],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[static::SCENARIO_NEW] = ['text'];

        return $scenarios;
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'text' => 'Текст сообщения'
        ];
    }
}
