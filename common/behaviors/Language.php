<?php namespace app\common\behaviors;

use app\modules\investor\models\Investor;
use yii\base\Behavior;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class Language extends Behavior
{
    private $languages = [
        'en' => 'en-EN',
        'ru' => 'ru-RU',
    ];

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'setLanguage'
        ];
    }

    /**
     * @return void
     */
    public function setLanguage()
    {
        $lang = \Yii::$app->request->get('lang');
        if (!empty($lang) && ArrayHelper::keyExists($lang, $this->languages)) {
            \Yii::$app->session->set('language', $this->languages[$lang]);
        } elseif (!\Yii::$app->session->has('language') && \Yii::$app->user->identity instanceof Investor) {
            \Yii::$app->session->set('language', \Yii::$app->user->getIsGuest()
                ? \Yii::$app->request->getPreferredLanguage(array_values($this->languages))
                : \Yii::$app->user->identity->lang);
        }

        \Yii::$app->language = \Yii::$app->formatter->locale = \Yii::$app->session->get('language');
    }
}