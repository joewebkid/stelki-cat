<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\StaticPages;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StaticPagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Static Pages';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="static-pages-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Static Pages', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'text:ntext',
            'title',
            'url:url',
            [
                'attribute' => 'position',
                'format' => 'raw',
                'content' => function ($model) {
                    return $model->positionName;
                },
                'filter' => StaticPages::getPositionArray()
            ],
            [
                'attribute' => 'active',
                'format' => 'raw',
                'content' => function ($model) {
                    return $model->activeName;
                },
                'filter' => StaticPages::getActiveArray()
            ],
            [
                'attribute' => 'priority',
                'format' => 'raw',
                'content' => function ($model) {
                    return $model->priority;
                },
                'filter' => StaticPages::priorityArray()
            ],
            'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
