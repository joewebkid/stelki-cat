<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Objects */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Объекты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="objects-view">

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
            // 'name',
            'coord_lat',
            'coord_len',
            'address',
            'residentialСomplexName',
            'region',
            'city',
            'district',
            'zone',
            'photos',
            'metro',
            'description',
            'area',
            'security',
            'price',
            'owner',
            'status',
            'type',
            'user_id',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
