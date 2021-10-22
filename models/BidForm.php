<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\components\validators\PhoneValidator;

class BidForm extends Model
{
    public $name;
    public $phone;
    public $email;

    public function rules()
    {
        return [
            [['name', 'phone', 'email'], 'required', 'message' => 'Не заполнен один или несколько параметров'],
            ['email', 'email', 'message' => 'Электронная почта неверно введена'],
            ['phone', PhoneValidator::className()]
        ];
    }
}

?>