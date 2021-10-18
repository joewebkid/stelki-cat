<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\modules\staff\models\StaffSearch $searchModel
 */

$this->title = Yii::t('app', 'Administrators');
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="content-box__heading">
    <?= Yii::t('app', 'Administrators') ?>
</div>
<div class="toolbar toolbar_position_top">
    <div class="toolbar__left-side">
        <?= Html::a(Yii::t('app', 'Send invite', [
            'modelClass' => 'Staff',
        ]), ['create'], ['class' => 'btn']) ?>
    </div>
</div>
<div class="content-box">
    
    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'pager' => [
            'class' => 'app\components\widgets\Pager'
        ],
        'layout' => '
                {items}
                <div class="toolbar toolbar_position_bottom">
                    <div class="pagination-info">
                        {summary}
                    </div>
                    {pager}
                </div>
            ',
        'tableOptions' => [
            'class' => 'table table_alternation table_text-trim'
        ],
        'columns' => [
            [
                'attribute' => 'login',
                'label' => Yii::t('app', 'Login')
            ], [
                'attribute' => 'status',
                'label' => Yii::t('app', 'Status'),
                'value' => function ($model) {
                    return $model->statusName;
                },
                'headerOptions' => ['width' => 180]
            ], [
                'attribute' => 'created_at',
                'label' => Yii::t('app', 'Creation date'),
                'format' => ['date', 'dd.MM.Y, HH:mm'],
                'headerOptions' => ['width' => 120]
            ], [
                'class' => \yii\grid\ActionColumn::className(),
                'headerOptions' => ['width' => 120],
                'contentOptions' => ['class' => 'action-column'],
                'buttons' => [
                    'block' => function ($url, $model) {
                        if ($model['status']) {
                            $url = Yii::$app->getUrlManager()->createUrl([
                                'admin/user/block',
                                'id' => $model['id']
                            ]);
                            return \yii\helpers\Html::a(Yii::t('app', 'Block'), $url, [
                                'data-pjax' => '0',
                                'class' => 'btn btn_size_small btn_type_outline'
                            ]);
                        } else {
                            $url = Yii::$app->getUrlManager()->createUrl([
                                'admin/user/unblock',
                                'id' => $model['id']
                            ]);
                            return \yii\helpers\Html::a(Yii::t('app', 'Unblock'), $url, [
                                'data-pjax' => '0',
                                'class' => 'btn btn_size_small btn_type_outline'
                            ]);
                        }
                    }
                ],
                'template' => '{block}'
            ]
        ]
    ]); ?>
    <?php Pjax::end(); ?>
</div>
