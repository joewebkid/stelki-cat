<?php

namespace app\controllers;

use Yii;
use app\models\ChangeEmails;
use app\models\ChangeEmailsSearch;
use app\models\Objects;
use app\models\Users;
use app\models\ResidentialComplexes;
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

//    public function beforeAction($action)
//    {
//        $this->enableCsrfValidation = false;
//    }

    public function actionAddCianObject()
    {
        \Yii::$app->controller->enableCsrfValidation = false;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $request = Yii::$app->request;
        $params = $request->post();

        if (!empty($params['jk']) && $params['jk'] != 'false') {
            $complexId = ResidentialComplexes::find()->where(['=', 'name', $params['jk']])->one();

            if (empty($complexId->id)) {
                $cm = new ResidentialComplexes();
                $cm->name = $params['jk'];
                $cm->save();
                $complexId = $cm->id;
            } else {
                $complexId = $complexId->id;
            }
        } else {
            $complexId = 0;
        }

        $raion = $this->getByParamName($params['address'], 'raion');
        if (!empty($raion) && $raion != 'false') {
            $districtsId = Districts::find()->where(['=', 'name', $raion])->one();
            if (empty($districtsId->id)) {
                $cm = new Districts();
                $cm->name = $raion;
                $cm->save();
                $districtsId = $cm->id;
            } else {
                $districtsId = $districtsId->id;
            }
        } else {
            $districtsId = 0;
        }


        //this->getByParamName($params['address'], 'location') . ', ' .

        $object = new Objects();
        $object->coord_lat = $params['coords']['lat'];
        $object->coord_len = $params['coords']['lng'];
        $object->address = $this->getByParamName($params['address'], 'street') . ', ' . $this->getByParamName($params['address'], 'house');
        $object->region = '';
        $object->name = $params['type_2'] . ' (' . $params['type_1'] . ')';
        $object->city = $this->getByParamName($params['address'], 'location');
        $object->district = $districtsId;
        $object->zone = $this->getByParamName($params['address'], 'okrug');
        $object->photos = $this->getPhotos($params['photos']);
        $object->metro = '';
        $object->description = $params['description'];
        $object->residential_сomplex_id = $complexId;
        $object->area = $params['totalArea'];
        $object->security = 1;
        $object->price = $params['priceTotalRur'];
        $object->owner = 0;
        $object->status = '';
        if ($params['dealType'] == 'sale') {
            $object->saleType = 0;
        } else {
            $object->saleType = 1;
        }
        $object->type = 0;
        $object->user_id = $this->getOrSetUserId($params['phone']);

        $object->save();

        return [0 => $object->getErrors()];
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
            $user->email = $phone . '@mashino-mesta.ru';
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
