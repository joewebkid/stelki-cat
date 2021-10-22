<?php 

namespace app\modules\staff\controllers;

use Yii;
use yii\web\Controller;
use app\models\Bids;
use app\models\BidsSearch;

class BidsController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new BidsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Bids::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}