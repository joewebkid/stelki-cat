<?php
/**
 * Created by PhpStorm.
 * User: Offereight
 * Date: 28.02.2020
 * Time: 17:59
 */

namespace app\components\validators;
use yii\validators\Validator;

class PhoneValidator extends Validator
{
    public function validateAttribute($model, $attribute)
    {
        // Телефон по типу +7(111)111-11-11, без пробелов
        if (!preg_match('/^\+7\([0-9]{3}\)[0-9]{3}\-[0-9]{2}\-[0-9]{2}$/', $model->$attribute)) {
            $this->addError($model, $attribute, 'Телефон неверно введен');
        }
    }
}