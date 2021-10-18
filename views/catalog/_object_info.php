<div class="descriptionBlock">
    <?php if ($model->description): ?>        
        <h2>Описание</h2>
        <div><?=$model->description?></div>
    <?php endif ?>
</div>

<div class="main__address">
    <div class="address" data-without-city=" пр-кт Ленинградский, дом 29, корпус 3">Город <?=$model->city?>,  <?=$model->address?></div>
    <!-- <div class="address__comm"></div> -->
    <div class="metro">
        <?php  
            $metros = json_decode($model->metro);
        ?> 
        <?php if ($metros): ?>            
            <?php foreach ($metros as $key => $metro): ?>            
                    <div class="metro__container">
                        <div class="metro__color-wrapper">
                            <div class="metro__color" style="background-color: #<?=$metro->color?>;"></div>
                        </div>
                        <div class="metro__name"><?=$metro->name?></div>
                        <div class="metro__additional__info"><?=$metro->distance?> ~ <?=$metro->duration?></div>
                    </div>
            <?php endforeach ?>
        <?php endif ?>
    </div>
</div>

<div class="main__characteristic">
    <div class="char__container">
        <div class="left__char">
            <div class="line__char">
                <span class="char__name">Тип</span>
                <span class="char__placeholder"></span>
                <span class="char__value"><?=$model->typeName?></span>
            </div>
            <div class="line__char">
                <span class="char__name">Площадь</span>
                <span class="char__placeholder"></span>
                <span class="char__value"><?=$model->area?> <span class="area__value">м<sup>2</sup></span> </span>
            </div>
            <div class="line__char">
                <span class="char__name">Охрана</span>
                <span class="char__placeholder"></span>
                <span class="char__value"><?=$model->securityName?></span>
            </div>
        </div>
        <div class="right__char">
            <div class="line__char">
                <span class="char__name">Район</span>
                <span class="char__placeholder"></span>
                <span class="char__value"><?=$model->districtName?></span>
            </div>
            <div class="line__char">
                <span class="char__name">В собственности</span>
                <span class="char__placeholder"></span>
                <span class="char__value"><?=$model->ownerName?></span>
            </div>
        </div>
    </div>

</div>