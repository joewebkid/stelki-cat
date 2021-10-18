<?php

namespace app\modules\staff\controllers;

use Yii;
use app\models\Objects;
use app\models\ObjectsSearch;
use app\models\Users;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ObjectsController implements the CRUD actions for Objects model.
 */
class ObjectsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Objects models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ObjectsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Objects model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Objects model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Objects();

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            if ($model->upload()) {
                $model->imageFiles = '';
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    foreach ($model->getErrors() as $key => $value) {
                        \Yii::$app->session->setFlash('error', $value);
                    }
                }

            }

        }


        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionCreateFromExcel()
    {
        $model = new Objects();

        if (Yii::$app->request->isPost) {
            $fl = UploadedFile::getInstance($model, 'excelFile');
            if (!$fl) {
                return $this->render('createFromExcel', [
                    'model' => $model,
                ]);
            }

            $nn = time() . "." . $fl->extension;
            $dnn = "uploads/excel/" . $nn;
            $fl->saveAs($dnn);

            $objPHPExcel = \PHPExcel_IOFactory::load($dnn);
            $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

            $parkings = [];;
            $i = 0;
            foreach ($sheetData as $k => $v) {
                if ($k < 2) {
                    continue;
                }
                $parkings[$i]['площадь'] = str_replace(', м2', '', $v['D']);
                $parkings[$i]['метро'] = $v['E'];
                $parkings[$i]['адрес'] = str_replace('Санкт-Петербург, ', '', $v['F']);
                $parkings[$i]['город'] = 'Санкт-Петербург';
                $parkings[$i]['цена'] = str_replace(' руб.', '', $v['H']);
                $parkings[$i]['телефон'] = $this->phone_number($v['J']);
                $parkings[$i]['телефон2'] = $v['J'];
                $parkings[$i]['описание'] = $v['K'];

                $i++;
            }

            @unlink($dnn);

            foreach ($parkings as $parking) {

                $userId = 0;
                $findPhone = Users::find()->where(['=', 'phone', $parking['телефон']])->one();
                if ($findPhone) {
                    $userId = $findPhone->id;
                } else {
                    $user = new Users();
                    $user->phone = $parking['телефон'];
                    $user->email = $parking['телефон2'] . '@mashino-mesta.ru';
                    $user->pwhash = '$2y$13$/dw98JdrKk8lXz72yhw/NeTy12iSkKDe3cZWAA1sGGxEBItg8iyOC';
                    $user->login = $parking['телефон2'];
                    $user->save();
                    $userId = $user->id;
                }

                $obj = new Objects();
                $obj->address = $parking['адрес'];
                $obj->coord_lat = '59.93761075430383';
                $obj->coord_len = '30.315612423278726';
                $obj->city = $parking['город'];
                $obj->type = 0;
                $obj->price = $parking['цена'];
                $obj->area = $parking['площадь'];
                $obj->description = $parking['описание'];
                $obj->saleType = 1;
                $obj->user_id = $userId;
                $obj->save();
            }

        }

        echo 'Загружено объектов: ' . count($parkings);
        exit;

        return $this->render('createFromExcel', [
            'model' => $model,
        ]);
    }

    function phone_number($sPhone)
    {
        return '+7 (' . $sPhone[2] . $sPhone[3] . $sPhone[4] . ') ' . $sPhone[5] . $sPhone[6] . $sPhone[7] . '-' . $sPhone[8] . $sPhone[9] . '-' . $sPhone[10] . $sPhone[11];
    }

    /**
     * Updates an existing Objects model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            if ($model->upload()) {
                $model->imageFiles = '';
//                 echo "<pre>";
// print_r($model);
// exit;
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    foreach ($model->getErrors() as $key => $value) {
                        \Yii::$app->session->setFlash('error', $value);
                    }
                }

            }

        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Objects model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Objects model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Objects the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Objects::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
