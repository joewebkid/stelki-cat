<?php

namespace app\controllers;

use Yii;
use app\models\ChangeEmails;
use app\models\ChangeEmailsSearch;
use app\models\Users;
use app\models\Districts;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ChangeEmailsController implements the CRUD actions for ChangeEmails model.
 */
class ApiController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
            ],
        ];
    }

    public function getByParamName($array, $paramName)
    {
        foreach ($array as $k => $v) {
            foreach ($v as $k2 => $v2) {
                if ($v2 == $paramName) {
                    return $v['name'];
                }
            }

        }

        return false;
    }

    public function getPhotos($param)
    {
        $photos = [];

        if (!$param) {
            return $photos;
        }

        foreach ($param as $item) {
            $url = $item['fullUrl'];
            $name = 'cian/' . rand(00000000, 99999999) . '.jpg';
            $path = \Yii::getAlias('@app') . '/web/uploads/' . $name;
            file_put_contents($path, file_get_contents($url));
            $photos[] = $name;
        }

        return json_encode($photos);
    }

    public function getOrSetUserId($phone)
    {
        $phone = $this->phoneNumber($phone);
        $findPhone = Users::find()->where(['=', 'phone', $phone])->one();

        if ($findPhone) {
            $userId = $findPhone->id;
        } else {
            $user = new Users();
            $user->phone = $phone;
            $user->email = $phone . '@future-step.ru';
            $user->pwhash = '$2y$13$/dw98JdrKk8lXz72yhw/NeTy12iSkKDe3cZWAA1sGGxEBItg8iyOC';
            $user->login = $phone;
            $user->save();
            $userId = $user->id;
        }

        return $userId;
    }

    public function phoneNumber($sPhone)
    {
        $sPhone = str_replace([' ', '-', '(', ')'], '', $sPhone);
        return '+7 (' . $sPhone[2] . $sPhone[3] . $sPhone[4] . ') ' . $sPhone[5] . $sPhone[6] . $sPhone[7] . '-' . $sPhone[8] . $sPhone[9] . '-' . $sPhone[10] . $sPhone[11];
    }
}
