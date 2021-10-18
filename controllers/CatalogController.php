<?php 
namespace app\controllers;
use app\models\Objects;
use app\models\SearchObjects;
use app\models\Metro;
use yii\data\ActiveDataProvider;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CatalogController extends Controller
{
    // public $layout = '@app/themes/app/layouts/default';

    public $enableCsrfValidation = false;
    /**
     * @return string
     */
    /**
    public function actionIndex()
    {
        $catalog = new SearchResidentialObject();

        if ( !empty(\Yii::$app->session->get('filterData')) ) {
	        $catalogParams = \Yii::$app->session->get('filterData');
        } else if ( empty($catalogParams = \Yii::$app->request->get('SearchResidentialObject')) )
            $catalogParams = array();

        $objectsProvider = $catalog->search($catalogParams);
        $metroProvider = Metro::find()->all();

        return $this->render('list', [
            'searchResidentialObject' => $catalog,
            'objectsProvider' => $objectsProvider,
            'metroProvider' => $metroProvider
        ]);
    }
     */

    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        // if ( empty($model = Object::find()->innerJoinWith(['properties'])->where(['objects.id' => $id])->one()) )
        if ( empty($model = Objects::findOne($id)) )
            throw new NotFoundHttpException('Такого объекта не существует');
        return $this->render('view', [
            'model' => $model
        ]);
    }

    public function actionSearchByMap () {  
        $searchModel = new \app\models\ObjectsSearch();
        $objectsProvider = $searchModel->search(\Yii::$app->request->queryParams, true)->all();

        $coords = [];
        $objects = [];
        foreach ($objectsProvider as $key => $value) {
            $objects[$value->id] = [
                'name' => $value->name,
                'type' => $value->typeName,
                'img' => $value->mainPhoto,
                'district' => $value->districtName,
                'address' => $value->address,
                'area' => $value->area,
                'price' => $value->price,
                'id' => $value->id,
            ];
        }
        $objects = json_encode($objects);

        foreach ($objectsProvider as $key => $value) {
            $coords[] = [
                'lat' => $value->coord_lat,
                'len' => $value->coord_len,
                'id' => $value->id,
            ];
        }
        $coords = json_encode($coords);

        return $this->render('by-map',compact('searchModel','objects','coords'));
    }

    public function actionFavorites()
    {
        // if (($favorite = \Yii::$app->request->cookies['favorite']) != null) {
        $favorite = \Yii::$app->request->cookies['favorite'];
        $favorite = json_decode($favorite, true);
        $objectModel = Objects::find()->where(['id' => $favorite]);

        $objectsProvider = new ActiveDataProvider([
            'query' => $objectModel,
            'pagination' => false,
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC
                ]
            ]
        ]);

        return $this->render('favorites', [
            'objectsProvider' => $objectsProvider,
        ]);
        // }
    }

    public function actionAddFavorite()
    {

        if (\Yii::$app->request->isAjax) {
            $id = \Yii::$app->request->get('id');

            if (($favorite = \Yii::$app->request->cookies['favorite']) == null) {
                \Yii::$app->response->cookies->add(new \yii\web\Cookie([
                    'name' => 'favorite',
                    'value' => json_encode([0 => $id])
                ]));
            } else {
                $favorite = json_decode($favorite, true);

                if (($elem = array_search($id, $favorite)) !== false) {
                    unset($favorite[$elem]);
                } else {
                    array_push($favorite, $id);
                }

                $favorite = array_unique($favorite);
                \Yii::$app->response->cookies->add(new \yii\web\Cookie([
                    'name' => 'favorite',
                    'value' => $favorite = json_encode($favorite)
                ]));
            }

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['favorite' => $favorite];
        }
    }


}
