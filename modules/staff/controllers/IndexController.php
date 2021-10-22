<?php 
namespace app\modules\staff\controllers;

use Yii;
use yii\web\Controller;
use \app\models\BidsSearch;

class IndexController extends Controller
{

    public function actionIndex()
    {
        $this->view->title = Yii::t('app', 'Dashboard');
        $searchModel = new BidsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', compact('dataProvider'));
    }
}
