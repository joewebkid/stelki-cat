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
        if (!preg_match('/^\+7\s\([0-9]{3}\)\s[0-9]{3}\-[0-9]{2}\-[0-9]{2}$/', $model->$attribute)) {
            $this->addError($model, $attribute, 'Attribute '.$attribute.' is not validate.');
        }
    }
}