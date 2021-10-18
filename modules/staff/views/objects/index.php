<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ObjectsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Объекты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="objects-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить объект', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Добавить из Excel', ['create-from-excel'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            'id',
            // 'name',
            'typeName',
            'districtName',
            'metroShortFormat:html',
            'address',
            //'city',
            //'district',
            //'zone',
            //'photos',
            //'metro',
            //'description',
            //'area',
            //'security',
            //'price',
            //'owner',
            //'status',
            //'type',
            //'user_id',
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
