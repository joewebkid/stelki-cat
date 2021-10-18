<?php
    use yii\helpers\Html;

    $favoriteClass = '';
    if ( ($favorite = \Yii::$app->request->cookies['favorite']) != null ) {
        
        $favorite = json_decode($favorite,true);
        if ( ($elem = array_search($model->id, $favorite))!==false ) {
            $favoriteClass = 'liked';
        }
    }
    // echo "<pre>";
    // print_r($model);
    // echo "</pre>";
?>

<div class="last-apartments__card <?=$favoriteClass?>" data-id="<?= $model->id ?>" data-name="<?= $model->name ?>" data-key="<?= $model->id ?>" data-lat="<?= $model->coord_lat ?>" data-lng="<?= $model->coord_len ?>">
    <div class="last-apartments__card-like"></div>
    <a href="/catalog/view/<?= $model->id ?>" target="_blank">
        <!--<div class="last-apartments__card-fast-view"></div>-->
        <div class="last-apartments__card-photo" style="background: url(<?=($model->mainPhoto?$model->mainPhoto:'/images/img-placeholder.jpg')?>);background-size: cover;background-position: center;">
           <!--  <div class="loader">
                <svg class="svg-inline--fa fa-sync fa-w-16 fa-spin" aria-hidden="true" data-prefix="fas" data-icon="sync" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                    <path fill="currentColor" d="M440.935 12.574l3.966 82.766C399.416 41.904 331.674 8 256 8 134.813 8 33.933 94.924 12.296 209.824 10.908 217.193 16.604 224 24.103 224h49.084c5.57 0 10.377-3.842 11.676-9.259C103.407 137.408 172.931 80 256 80c60.893 0 114.512 30.856 146.104 77.801l-101.53-4.865c-6.845-.328-12.574 5.133-12.574 11.986v47.411c0 6.627 5.373 12 12 12h200.333c6.627 0 12-5.373 12-12V12c0-6.627-5.373-12-12-12h-47.411c-6.853 0-12.315 5.729-11.987 12.574zM256 432c-60.895 0-114.517-30.858-146.109-77.805l101.868 4.871c6.845.327 12.573-5.134 12.573-11.986v-47.412c0-6.627-5.373-12-12-12H12c-6.627 0-12 5.373-12 12V500c0 6.627 5.373 12 12 12h47.385c6.863 0 12.328-5.745 11.985-12.599l-4.129-82.575C112.725 470.166 180.405 504 256 504c121.187 0 222.067-86.924 243.704-201.824 1.388-7.369-4.308-14.176-11.807-14.176h-49.084c-5.57 0-10.377 3.842-11.676 9.259C408.593 374.592 339.069 432 256 432z"></path></svg>
            </div> -->
            <!--         $asset->baseUrl . '/images/card-photo.png' -->
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
                <span class="price"><?= $model->price ?> <span class="rub">&#8381;</span></span>
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
