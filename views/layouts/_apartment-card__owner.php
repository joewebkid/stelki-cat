<?php
    use yii\helpers\Html;

    $favoriteClass = '';
    if ( ($favorite = \Yii::$app->request->cookies['favorite']) != null ) {
        
        $favorite = json_decode($favorite,true);
        if ( ($elem = array_search($model->id, $favorite))!==false ) {
            $favoriteClass = 'liked';
        }
    }
?>

<div class="last-apartments__card <?=$favoriteClass?>" data-id="<?= $model->id ?>" data-name="<?= $model->name ?>" data-key="<?= $model->id ?>" data-lat="<?= $model->coord_lat ?>" data-lng="<?= $model->coord_len ?>">
    <div class="last-apartments__card-like"></div>
    <a href="/catalog/view/<?= $model->id ?>" target="_blank">
        <!--<div class="last-apartments__card-fast-view"></div>-->
        <div class="last-apartments__card-photo" style="background: url(<?=($model->mainPhoto?$model->mainPhoto:'/images/img-placeholder.jpg')?>);background-size: cover;background-position: center;">
  
        </div>
        <div class="last-apartments__card-info">
            <div class="last-apartments__card-top-info">
                <span class="rooms" data-rooms-quantity="<?= $model->type ?>"><?= $model->typeName ?></span>
                <span class="dot">&#149;</span>
                <span class="area"><?= $model->districtName ?> </span>
                <span class="dot">&#149;</span>
                <span class="floor">                    
                    <span class="area"><?= $model->area ?> м<sup>2</sup></span>
                </span>
            </div>
          <!--   <div class="last-apartments__card-name">
                <?= $model->typeName ?> <?= $model->districtName ?>  <span class="area"><?= $model->area ?> м&sup2;</span>
            </div> -->
            <div class="last-apartments__card-price">
                <span class="price"><?= number_format((int)$model->price, 0, ',', ' ') ?> <span class="rub">&#8381;</span></span>
                <span class="price-for-m"> <span class="rub"></span> <sup></sup></span>
            </div>
            <div class="last-apartments__card-address">
                <?= $model->city ?>,
                <?= $model->region ?>
                <?= $model->address ?>
            </div>
            <div class="last-apartments__card-metro">
                <?= $model->metroShortFormat ?>
            </div>
        </div>
    </a>
</div>
