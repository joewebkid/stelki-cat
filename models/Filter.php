<?php

namespace app\models;

use Yii;
use app\models\Metro;
use app\models\Objects;
use yii\helpers\Html;

/**
 * This is the model class for table "metro".
 * https://api.hh.ru/metro/2
 * @property int $id Id
 * @property int $object_id Id объекта
 * @property int $metro_id Id метро
 * @property int $metro_distance Расстояние до метро в метрах
 * @property int $metro_time Время до метро в минутах
 * @property string $created_at
 * @property string $updated_at
 */
class Filter extends \yii\base\Model
{
	private static $footLen = 6;
	public static function getStandartUrl () {
		// return ((Yii::$app->controller->action->id=='search-by-map')?'/catalog/search-by-map':'/site/index').'?ObjectsSearch';
        return '/site/index?ObjectsSearch';
	}

    public static function getMetros () {
    	$s = '';
    	$i = self::$footLen;
    	foreach (Metro::getStation() as $key => $value) {
    		if($key==190) continue;
    		if($key==191) continue;
    		if($key==192) continue;
    		if($key==193) continue;
    		if($key==194) continue;
    		if($key==195) continue;
    		if($key==196) continue;
    		if($key==197) continue;
    		if(!$i) break;
    		$s .= Html::a($value['name'], self::getStandartUrl().'%5Bmetro%5D='.$value['name']);
    		$i--;
    		# code...
    	}
    	echo $s;
    }
    public static function getDictricts () {
    	$s = '';
    	$i = self::$footLen;
    	foreach (Objects::getDistrictMap() as $key => $value) {
    		if(!$i) break;
    		$s .= Html::a($value, self::getStandartUrl().'%5Bdistrict%5D%5B%5D='.$key);
    		$i--;
    		# code...
    	}
    	echo $s;
    }
    public static function getResidentialСomplex () {
    	$s = '';
    	$i = self::$footLen;
    	foreach (Objects::getResidentialСomplexMap() as $key => $value) {
    		if(!$i) break;
    		$s .= Html::a($value, self::getStandartUrl().'%5Bresidential_сomplex_id%5D%5B%5D='.$key);
    		$i--;
    		# code...
    	}
    	echo $s;
    }
}