<?php
use yii\widgets\ListView;

/* @var $this yii\web\View */

$this->title = ' Машиноместо - главная';
?>
<div class="">
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="content container">
	    <?= ListView::widget([
		    'dataProvider' => $objectsProvider,
		    'itemView' => '../layouts/_apartment-card__owner',
		    'options' => [
		        'tag' => 'div',
		        'class' => 'last-apartments__cards',
		        'id' => 'last-apartments__cards'
		    ],

		    'emptyText' => 'По Вашему запросу ничего не найдено. Измените значения фильтра.
                 <style>
                    .last-apartments__wrapper {
                        min-height: 600px;
                    }
                 </style>',
		    'itemOptions' => [
		        'tag' => false
		    ],
		    'layout' => "{sorter}<div class='items'>{items}</div>{pager}",
		    // 'viewParams' => [
		    //     'asset' => $asset,
		    // ],
		    'sorter' => [
		    	'attributes' => [
		    		'price',
		    		'area',
		    	]
		    ],
		    'pager' => [
		        'maxButtonCount' => 10,
		        'pageCssClass' => 'duff',
		        'lastPageLabel' => '&#187;',
		        'nextPageLabel' => '&#8250;',
		        'firstPageLabel' => '&#171;',
		        'prevPageLabel' => '&#8249;'
		    ]
		]); ?>
	</div>
</div>