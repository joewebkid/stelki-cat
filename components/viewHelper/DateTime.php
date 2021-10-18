<?php
namespace app\components\viewHelper;

use app\models\Smshash;
use yii\base\Component;
use Yii;

class DateTime extends Component {

    public $months = [
        'января',
        'февраля',
        'марта',
        'апреля',
        'мая',
        'июня',
        'июля',
        'августа',
        'сентября',
        'октября',
        'ноября',
        'декабря'
    ];

    public function monthString($month){
        if(empty($this->months[$month+1])){
            return '';
        }else{
            return $this->months[$month+1];
        }
    }
}