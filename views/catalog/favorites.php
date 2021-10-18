<?php
$this->title = Yii::t('app', 'Избранное');
?>
<div class="container">
	<h2>Избранное</h2>
	<br>
	<div class="section last-apartments">
		<?= \yii\widgets\ListView::widget([
			'dataProvider' => $objectsProvider,
			'itemView' => '@app/views/layouts/_apartment-card',
			'options' => [
				'tag' => 'div',
				'class' => 'last-apartments__cards',
				'id' => 'last-apartments__cards'
			],
			'itemOptions' => [
				'tag' => false
			],
			'layout' => '{items}',
            'emptyText' => 'Пока здесь пусто. Добавьте объекты, которые вас заинтересовали.'
		]); ?>
	</div>
</div>