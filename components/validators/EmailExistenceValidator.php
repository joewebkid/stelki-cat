<?php
/**
 * Created by PhpStorm.
 * User: Offereight
 * Date: 28.02.2020
 * Time: 17:59
 */

namespace app\components\validators;
use yii\validators\Validator;
use app\models\Users;

class EmailExistenceValidator extends Validator
{
    public function validateAttribute($model, $attribute)
    {
        if(!Users::find()->where(['email' => $model->$attribute])->one()){
            $this->addError($model, $attribute, 'Email not found.');
        }
    }
}