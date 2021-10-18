<?php

namespace app\models;

use Yii;

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
class Metro extends \yii\db\ActiveRecord
{
    /**
     * 
     * {@inheritdoc}
     */
    
    public static function tableName()
    {
        return 'metro';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['object_id', 'metro_id'], 'required'],
            [['object_id', 'metro_id', 'metro_distance', 'metro_time'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'object_id' => 'Id объекта',
            'metro_id' => 'Id метро',
            'metro_distance' => 'Расстояние до метро в метрах',
            'metro_time' => 'Время до метро в минутах',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    public static function getLines() {
        return [
            14=>["hex_color"=>"D6083B","name"=>"Кировско-Выборгская"],
            15=>["hex_color"=>"0078C9","name"=>"Московско-Петроградская"],
            16=>["hex_color"=>"009A49","name"=>"Невско-Василеостровская"],
            17=>["hex_color"=>"EA7125","name"=>"Правобережная"],
            18=>["hex_color"=>"702785","name"=>"Фрунзенско-Приморская"],
        ];
    }

    public static function getStationMap()
    {
        $station = self::getStation();
        $lines = self::getLines();
        $res = [];
        foreach ($station as $key => $value) {
            $parent = $value['parent'];
            $lineName = $lines[$parent]['name'];
            if(!isset($res[$lineName])) $res[$lineName]=[];
            $res[$lineName][$key] = $value['name'];
        }
        return $res;
    }
    public static function distance($longitude1, $latitude1, $longitude2, $latitude2){
     
        // Средний радиус Земли в метрах
        $earthRadius = 6372797;
     
        $dLat = deg2rad($latitude2 - $latitude1);
        $dLon = deg2rad($longitude2 - $longitude1);
     
        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon/2) * sin($dLon/2);
        $c = 2 * asin(sqrt($a));
        $distance = ceil($earthRadius * $c);
     
        return $distance;
    }

    public static function getStation()
    {
        return [
            190=>["name"=>"Девяткино","lat"=>60.050182,"lng"=>30.443045,"order"=>0,'parent'=>14],
            191=>["name"=>"Гражданский проспект","lat"=>60.034969,"lng"=>30.418224,"order"=>1,'parent'=>14],
            192=>["name"=>"Академическая","lat"=>60.012806,"lng"=>30.396044,"order"=>2,'parent'=>14],
            193=>["name"=>"Политехническая","lat"=>60.008942,"lng"=>30.370907,"order"=>3,'parent'=>14],
            194=>["name"=>"Площадь Мужества","lat"=>59.999828,"lng"=>30.366159,"order"=>4,'parent'=>14],
            195=>["name"=>"Лесная","lat"=>59.984947,"lng"=>30.344259,"order"=>5,'parent'=>14],
            196=>["name"=>"Выборгская","lat"=>59.970925,"lng"=>30.347408,"order"=>6,'parent'=>14],
            197=>["name"=>"Площадь Ленина","lat"=>59.955611,"lng"=>30.35605,"order"=>7,'parent'=>14],
            198=>["name"=>"Чернышевская","lat"=>59.94453,"lng"=>30.359919,"order"=>8,'parent'=>14],
            199=>["name"=>"Площадь Восстания","lat"=>59.930279,"lng"=>30.361069,"order"=>9,'parent'=>14],
            200=>["name"=>"Владимирская","lat"=>59.927628,"lng"=>30.347898,"order"=>10,'parent'=>14],
            201=>["name"=>"Пушкинская","lat"=>59.92065,"lng"=>30.329599,"order"=>11,'parent'=>14],
            202=>["name"=>"Технологический институт","lat"=>59.916512,"lng"=>30.318485,"order"=>12,'parent'=>14],
            203=>["name"=>"Балтийская","lat"=>59.907211,"lng"=>30.299578,"order"=>13,'parent'=>14],
            204=>["name"=>"Нарвская","lat"=>59.901218,"lng"=>30.274908,"order"=>14,'parent'=>14],
            205=>["name"=>"Кировский завод","lat"=>59.879688,"lng"=>30.261921,"order"=>15,'parent'=>14],
            206=>["name"=>"Автово","lat"=>59.867325,"lng"=>30.261337,"order"=>16,'parent'=>14],
            207=>["name"=>"Ленинский проспект","lat"=>59.85117,"lng"=>30.268274,"order"=>17,'parent'=>14],
            208=>["name"=>"Проспект Ветеранов","lat"=>59.84211,"lng"=>30.250588,"order"=>18,'parent'=>14],

            209=>["name"=>"Парнас","lat"=>60.06699,"lng"=>30.333839,"order"=>0,'parent'=>15],
            210=>["name"=>"Проспект Просвещения","lat"=>60.051456,"lng"=>30.332544,"order"=>1,'parent'=>15],
            211=>["name"=>"Озерки","lat"=>60.037098,"lng"=>30.321495,"order"=>2,'parent'=>15],
            212=>["name"=>"Удельная","lat"=>60.016697,"lng"=>30.315607,"order"=>3,'parent'=>15],
            213=>["name"=>"Пионерская","lat"=>60.002487,"lng"=>30.296759,"order"=>4,'parent'=>15],
            214=>["name"=>"Чёрная речка","lat"=>59.985455,"lng"=>30.300833,"order"=>5,'parent'=>15],
            215=>["name"=>"Петроградская","lat"=>59.966389,"lng"=>30.311293,"order"=>6,'parent'=>15],
            216=>["name"=>"Горьковская","lat"=>59.956112,"lng"=>30.31889,"order"=>7,'parent'=>15],
            217=>["name"=>"Невский проспект","lat"=>59.935421,"lng"=>30.327052,"order"=>8,'parent'=>15],
            218=>["name"=>"Сенная площадь","lat"=>59.927135,"lng"=>30.320316,"order"=>9,'parent'=>15],
            219=>["name"=>"Технологический институт 2","lat"=>59.916512,"lng"=>30.318485,"order"=>10,'parent'=>15],
            220=>["name"=>"Фрунзенская","lat"=>59.906273,"lng"=>30.31745,"order"=>11,'parent'=>15],
            221=>["name"=>"Московские ворота","lat"=>59.891788,"lng"=>30.317873,"order"=>12,'parent'=>15],
            222=>["name"=>"Электросила","lat"=>59.879189,"lng"=>30.318659,"order"=>13,'parent'=>15],
            223=>["name"=>"Парк Победы","lat"=>59.866344,"lng"=>30.321802,"order"=>14,'parent'=>15],
            224=>["name"=>"Московская","lat"=>59.848873,"lng"=>30.321483,"order"=>15,'parent'=>15],
            225=>["name"=>"Звёздная","lat"=>59.833241,"lng"=>30.349428,"order"=>16,'parent'=>15],
            226=>["name"=>"Купчино","lat"=>59.829781,"lng"=>30.375702,"order"=>17,'parent'=>15],

            604=>["name"=>"Беговая","lat"=>59.98723,"lng"=>30.20247,"order"=>0,'parent'=>16],
            605=>["name"=>"Новокрестовская","lat"=>59.9716,"lng"=>30.2117,"order"=>1,'parent'=>16],
            227=>["name"=>"Приморская","lat"=>59.948521,"lng"=>30.23447,"order"=>2,'parent'=>16],
            228=>["name"=>"Василеостровская","lat"=>59.942577,"lng"=>30.278254,"order"=>3,'parent'=>16],
            229=>["name"=>"Гостиный двор","lat"=>59.933933,"lng"=>30.33341,"order"=>4,'parent'=>16],
            230=>["name"=>"Маяковская","lat"=>59.931366,"lng"=>30.354645,"order"=>5,'parent'=>16],
            231=>["name"=>"Площадь Александра Невского 1","lat"=>59.924369,"lng"=>30.384989,"order"=>6,'parent'=>16],
            232=>["name"=>"Елизаровская","lat"=>59.89669,"lng"=>30.423656,"order"=>7,'parent'=>16],
            233=>["name"=>"Ломоносовская","lat"=>59.877342,"lng"=>30.441715,"order"=>8,'parent'=>16],
            234=>["name"=>"Пролетарская","lat"=>59.865215,"lng"=>30.470264,"order"=>9,'parent'=>16],
            235=>["name"=>"Обухово","lat"=>59.848709,"lng"=>30.457743,"order"=>10,'parent'=>16],
            236=>["name"=>"Рыбацкое","lat"=>59.830986,"lng"=>30.501259,"order"=>11,'parent'=>16],

            237=>["name"=>"Спасская","lat"=>59.927135,"lng"=>30.320316,"order"=>0,'parent'=>17],
            238=>["name"=>"Достоевская","lat"=>59.928234,"lng"=>30.346029,"order"=>1,'parent'=>17],
            239=>["name"=>"Лиговский проспект","lat"=>59.920811,"lng"=>30.355055,"order"=>2,'parent'=>17],
            240=>["name"=>"Площадь Александра Невского 2","lat"=>59.923563,"lng"=>30.383421,"order"=>3,'parent'=>17],
            241=>["name"=>"Новочеркасская","lat"=>59.929092,"lng"=>30.411915,"order"=>4,'parent'=>17],
            242=>["name"=>"Ладожская","lat"=>59.93243,"lng"=>30.439274,"order"=>5,'parent'=>17],
            243=>["name"=>"Проспект Большевиков","lat"=>59.919838,"lng"=>30.466757,"order"=>6,'parent'=>17],
            244=>["name"=>"Улица Дыбенко","lat"=>59.907417,"lng"=>30.483311,"order"=>7,'parent'=>17],

            245=>["name"=>"Комендантский проспект","lat"=>60.008591,"lng"=>30.258663,"order"=>0,'parent'=>18],
            246=>["name"=>"Старая Деревня","lat"=>59.989433,"lng"=>30.255163,"order"=>1,'parent'=>18],
            247=>["name"=>"Крестовский остров","lat"=>59.971821,"lng"=>30.259436,"order"=>2,'parent'=>18],
            248=>["name"=>"Чкаловская","lat"=>59.961033,"lng"=>30.292006,"order"=>3,'parent'=>18],
            249=>["name"=>"Спортивная","lat"=>59.952026,"lng"=>30.291338,"order"=>4,'parent'=>18],
            258=>["name"=>"Адмиралтейская","lat"=>59.935867,"lng"=>30.31523,"order"=>5,'parent'=>18],
            250=>["name"=>"Садовая","lat"=>59.926739,"lng"=>30.317753,"order"=>6,'parent'=>18],
            251=>["name"=>"Звенигородская","lat"=>59.92065,"lng"=>30.329599,"order"=>7,'parent'=>18],
            252=>["name"=>"Обводный Канал","lat"=>59.914686,"lng"=>30.34815,"order"=>8,'parent'=>18],
            253=>["name"=>"Волковская","lat"=>59.896023,"lng"=>30.35754,"order"=>9,'parent'=>18],
            259=>["name"=>"Бухарестская","lat"=>59.883769,"lng"=>30.368932,"order"=>10,'parent'=>18],
            260=>["name"=>"Международная","lat"=>59.870203,"lng"=>30.379289,"order"=>11,'parent'=>18],
            682=>["name"=>"Дунайская","lat"=>50.5023,"lng"=>30.2438,"order"=>12,'parent'=>18],
            683=>["name"=>"Проспект Славы","lat"=>59.2127,"lng"=>30.2339,"order"=>13,'parent'=>18],
            684=>["name"=>"Шушары","lat"=>59.4912,"lng"=>30.2558,"order"=>14,'parent'=>18]

        ];
    }
}
