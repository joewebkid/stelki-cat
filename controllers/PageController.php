<?php

namespace app\controllers;


use app\models\Users;
use app\models\StaticPages;
use yii\web\NotFoundHttpException;
use Yii;
use yii\web\Controller;


class PageController extends Controller
{
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex($url)
    {
        $page = StaticPages::find()->where(['AND', ['=', 'url', $url], ['=', 'active', StaticPages::ACTIVE_YES]])->one();

        if(!$page){
            throw new NotFoundHttpException('Page not found.');
        }

        $user = Users::findOne(Yii::$app->user->getId());
        $searchModel = new \app\models\ObjectsSearch();
        $objectsProvider = $searchModel->search([
            'ObjectsSearch' => [
                'user_id' => Yii::$app->user->id,
            ]
        ]);
        return $this->render('index', compact(
            'user',
            'page'
        ));
    }
}
