<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Objects */

$this->title = 'Изменение объекта: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Объекты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменение';
?>
<div class="objects-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
