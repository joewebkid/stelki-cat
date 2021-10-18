<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\StaticPages */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Static Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="static-pages-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            [
                'attribute' => 'position',
                'format' => 'raw',
                'value' => function($data){
                    return $data->positionName;
                }
            ],
            [
                'attribute' => 'active',
                'format' => 'raw',
                'value' => function($data){
                    return $data->activeName;
                }
            ],
            'url:url',
            'priority',
            'text:ntext',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
