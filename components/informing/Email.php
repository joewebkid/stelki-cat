<?php

namespace app\components\informing;

use app\models\ChangeEmails;
use app\models\Emailhash;
use yii\base\Component;
use Yii;

class Email extends Component
{

    /**
     * @param $email
     * @param $label
     * @param $text
     * @param string $type_from
     * @return bool
     */
    public function send($email, $label, $body, $type_from)
    {
        if (empty($email)) {
            return false;
        }

        $email_from = ChangeEmails::emailFrom($type_from);

        Yii::$app->mailer->compose('default', ['label' => $label ,'body' => $body])
            ->setFrom($email_from)
            ->setTo($email)
            ->setSubject($label)
            ->send();

    }

    public function sendToHelp($label, $body, $from)
    {
        Yii::$app->mailer->compose()
            ->setFrom($from)
            ->setTo(\Yii::$app->params['helpEmail'])
            ->setSubject($label)
            ->setHtmlBody($body)
            ->send();
    }


    static public function getHash($user_id, $type, $hash)
    {
        return Emailhash::find()->where(['type' => $type])->andWhere(['user_id' => $user_id])->andWhere(['hash' => $hash])->one();
    }

    static public function deleteHash($user_id, $type, $hash)
    {
        if ($old = Emailhash::find()->where(['type' => $type])->andWhere(['user_id' => $user_id])->andWhere(['hash' => $hash])->one()) {
            $old->delete();
            return true;
        }

        return false;
    }

    static public function setHash($user_id, $type)
    {
        foreach (Emailhash::find()->where(['type' => $type])->andWhere(['user_id' => $user_id])->all() as $olds) {
            $olds->delete();
        }

        $email = new Emailhash();
        $email->user_id = $user_id;
        $email->type = $type;
        $email->hash = Emailhash::generate();
        $email->save();

        return $email->hash;
    }

}