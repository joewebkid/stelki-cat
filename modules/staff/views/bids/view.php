<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Заявка';
$this->params['breadcrumbs'][] = ['label' => 'Заявка', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="page-content-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'phone',
            'email',
            'created_at'
        ],
    ]) ?>

</div>
