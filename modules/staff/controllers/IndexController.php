<?php 
namespace app\modules\staff\controllers;

use Yii;
use yii\web\Controller;

class IndexController extends Controller
{

    public function actionIndex()
    {
        $this->view->title = Yii::t('app', 'Dashboard');

        return $this->render('index');
    }
}
