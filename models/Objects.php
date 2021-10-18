<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\Metro;
use app\models\ResidentialComplexes;
use app\models\Districts;
use app\models\Users;

/**
 * This is the model class for table "objects".
 *
 * @property int $id
 * @property string $coord_lat Широта
 * @property string $coord_len Долгота
 * @property string $address Улица, корпус, дом
 * @property string $region Регион
 * @property string $city Город
 * @property string $district Район
 * @property string $zone Округ
 * @property string $photos Фотки в формате "foto1.jpg,photo2.png"
 * @property string $metro Информация о метро (json)
 * @property string $description Описание объекта
 * @property string $area Площадь
 * @property string $security Охрана
 * @property string $price Цена
 * @property int $owner Собственник или агенство 0/1
 * @property int $status Статус объекта
 * @property int $type Тип объекта
 * @property int $user_id Id владельца объекта
 * @property int $created_at
 * @property int $updated_at
 */
class Objects extends \yii\db\ActiveRecord
{
    public $imageFiles;
    public $excelFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'objects';
    }

    public function behaviors()
    {
        return [\yii\behaviors\TimestampBehavior::class];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['coord_lat', 'coord_len', 'address', 'city', 'area', 'price'], 'required', 'message' => 'Поле "{attribute}" должно быть заполнено'],
            [['owner', 'status', 'type', 'user_id', 'saleType', 'residential_сomplex_id'], 'integer'],
            [['name', 'coord_lat', 'coord_len', 'address', 'region', 'city', 'zone', 'area', 'price'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 2000],
            [['metro'], 'string', 'max' => 2555],
            [['name', 'photos', 'security', 'district'], 'safe'],
            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 7, 'maxSize' => 9216*9216*1],
            [['excelFile'], 'file', 'skipOnEmpty' => true],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'coord_lat' => 'Широта',
            'coord_len' => 'Долгота',
            'address' => 'Улица, корпус, дом',
            'region' => 'Регион',
            'city' => 'Город',
            'district' => 'Район',
            'excelFile' => 'Файл Excel',
            'districtName' => 'Район',
            'metroShortFormat' => 'Метро',
            'residential_сomplex_id' => 'ЖК',
            'residentialСomplex' => 'ЖК',
            'residentialСomplexName' => 'Жилой комплекс',
            'zone' => 'Округ',
            'photos' => 'Фото в формате \"foto1.jpg,photo2.png\"',
            'metro' => 'Ближайшие станции метро',
            'description' => 'Описание объекта',
            'area' => 'Площадь',
            'security' => 'Охрана',
            'price' => 'Цена',
            'owner' => 'Агенство',
            'status' => 'Статус объекта',
            'type' => 'Тип объекта',
            'typeName' => 'Тип объекта',
            'user_id' => 'Id владельца объекта',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getMetroShortFormat()
    {
        if ($this->metro) {
            $this->metro = json_decode($this->metro);
            $colors = '<div class="colors">';
            $stationNames = array();

            foreach ($this->metro as $station) {
                $colors .= "<span class='metroStation'><span class='color' style='background-color: #{$station->color};'></span>{$station->name}</span>";
            }

            $colors .= '</div>';

            return $colors;
        }
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->user_id = $this->user_id ?? Yii::$app->user->id;
            $this->name = '';
            return true;
        }
        return false;
    }

    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    // /**
    //  * @return \yii\db\ActiveQuery
    //  */
    // public function getMetro()
    // {
    //     return $this->hasOne(Metro::className(), ['object_id' => 'id']);
    // }

    // public function getMetroObject() {
    //     $stations = Metro::getStation();
    //     $lines = Metro::getLines();

    //     $res = [];
    //     foreach (json_decode($this->metro) as $key => $metroId) {
    //         $station = $stations[$metroId];
    //         $color = $lines['parent']['hex_color'];
    //         $distance = Metro::
    //         $res[] = [
    //             'color' => $color,
    //             'name' => $station['name'],
    //         ];
    //     }
    // }

    public function upload()
    {
        if (!$this->imageFiles)
            return true;

        $r = [];
        if ($this->validate()) {
            foreach ($this->imageFiles as $file) {
                $r[] = $file->baseName . '.' . $file->extension;
                $file->saveAs('uploads/' . $file->baseName . '.' . $file->extension);
            }
//            $this->photos = json_encode($r);
            return true;
        } else {
            return false;
        }
    }

    public function removeOldPhotos()
    {
        $photos = json_decode($this->photos);
        foreach ($photos as $photo) {
            unlink('uploads/' . $photo);
        }
    }

    public function getPhotosHtml()
    {
        if (!$this->photosArray) return '';
        $preview = '';
        foreach ($this->photosArray as $key => $photo) {
            $preview .= Html::tag('div', "", ['style' => 'background:url(/uploads/' . $photo . ') center center / cover no-repeat black;background-position: center;', 'class' => 'swiper-slide item']);
        }
        return $preview;
    }

    public function getPhotosArray()
    {
        return json_decode($this->photos);
    }

    public function getMainPhoto()
    {
        if ($this->photosArray)
            return '/uploads/' . current($this->photosArray);
        else
            return '';
    }

    public function getDistrictName()
    {
        if(isset(self::getDistrictMap()[$this->district])){
            return self::getDistrictMap()[$this->district];
        }
        return false;
    }

    public function getDate()
    {
        return date('d.m.Y', $this->updated_at);
    }

    public static function getSecurityMap()
    {
        return [
            0 => 'Без охраны',
            1 => 'Есть охрана',
        ];
    }

    public function getSecurityName()
    {
        return self::getSecurityMap()[$this->security??0];
    }

    public static function getStatusMap()
    {
        return [
            0 => 'На проверке',
            1 => 'Активный',
            2 => 'Запрешен',
        ];
    }

    public function getStatusName()
    {
        return self::getStatusMap()[$this->status??0];
    }

    public static function getOwnerMap()
    {
        return [
            0 => 'Собственник',
            1 => 'Агенство',
        ];
    }

    public function getOwnerName()
    {
        return self::getOwnerMap()[$this->owner??0];
    }

    public static function getDistrictMap()
    {
        $districts = [];
        foreach(Districts::find()->select('id,name')->asArray()->all() as $k=> $v){
            $districts[$v['id']] = $v['name'];
        }

        return $districts;
    }

    public static function getResidentialСomplexSelectMap()
    {
        return [0 => 'Не указано'] + self::getResidentialСomplexMap();
    }

    public static function getResidentialСomplexMap()
    {
        $complex = [];
        foreach(ResidentialComplexes::find()->select('id,name')->asArray()->all() as $k=> $v){
            $complex[$v['id']] = $v['name'];
        }

        return $complex;
    }

    public function getResidentialСomplexName()
    {
        return self::getResidentialСomplexSelectMap()[$this->residential_сomplex_id];
    }

    public static function getTypeMap()
    {
        return [
            0 => 'Место в паркинге',
            1 => 'Машиноместо',
            2 => 'Гараж',
            3 => 'Кладовка',
            4 => 'Иное',
        ];
    }

    public static function getUsersMap()
    {
        $users = Users::find()->select(['id', 'login'])->asArray()->all();
        return ArrayHelper::map($users, 'id', 'login');
    }

    public function getTypeName()
    {
        return self::getTypeMap()[$this->type];
    }
}
