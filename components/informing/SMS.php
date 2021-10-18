<?php

namespace app\components\informing;

use app\models\Smshash;
use yii\base\Component;
use Yii;

class SMS extends Component
{

    const LOGIN = "Offereight";
    const PASSWORD = "oklick280492";

    /**
     * Отправить смс
     * @param string $phone
     * @param string $text
     * @return int
     * <ul>
     *  <li>SMS_SENDED - смс отправлено</li>
     *  <li>SMS_OPERATOR_ERROR - смс не отправлено оператором</li>
     *  <li>SMS_MODE_DISSALOW - невозможно отправить в данном режиме работы приложениия</li>
     * </ul>
     */
    public function send($phone, $text)
    {
        if (empty($phone) || empty($text)) {
            return false;
        }

        Yii::debug("Trying to send SMS '{$text}' to '{$phone}'...");

        $number = str_replace(['(', ')', ' '], '', $phone);
        if (true === ($sendRes = self::performSendSms($number, $text))) {
            Yii::debug("SMS '{$text}' was send to '{$phone}'");
            return true;
        } else {
            Yii::debug("Error send SMS '{$text}' to '{$phone}'. Reason: {$sendRes}");
            return false;
        }
    }

    static public function getHash($user_id, $type, $hash)
    {
        return Smshash::find()->where(['type' => $type])->andWhere(['user_id' => $user_id])->andWhere(['hash' => $hash])->one();
    }

    static public function deleteHash($user_id, $type, $hash)
    {
        if($old = Smshash::find()->where(['type' => $type])->andWhere(['user_id' => $user_id])->andWhere(['hash' => $hash])->one()){
            $old->delete();
            return true;
        }

        return false;
    }

    static public function setHash($user_id, $type)
    {

        foreach (Smshash::find()->where(['type' => $type])->andWhere(['user_id' => $user_id])->all() as $olds) {
            $olds->delete();
        }

        $sms = new Smshash();
        $sms->user_id = $user_id;
        $sms->type = $type;
        $sms->hash = Smshash::generate();
        $sms->save();

        return $sms->hash;
    }

    private function performSendSms($number, $text)
    {

        $ch = curl_init("http://smsc.ru/sys/send.php?login=" . self::LOGIN . "&psw=" . self::PASSWORD . "&phones=" . $number . "&mes=" . $text); // such as http://example.com/example.xml
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

}