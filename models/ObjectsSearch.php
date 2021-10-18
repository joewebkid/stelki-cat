<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Objects;

/**
 * ObjectsSearch represents the model behind the search form of `app\models\Objects`.
 */
class ObjectsSearch extends Objects
{
    public $price_from;
    public $price_to;
    public $area_from;
    public $area_to;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'owner', 'status', 'user_id', 'created_at', 'updated_at', 'saleType', 'user_id'], 'integer'],
            [['coord_lat', 'coord_len', 'address', 'region', 'city','type','price_from','price_to','area_from','area_to',  'district', 'zone', 'photos', 'metro', 'description', 'area', 'security', 'price', 'residential_сomplex_id'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $returnQuery=false)
    {
        $query = Objects::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            // 
            if($returnQuery) return $query;
            return $dataProvider;
        }
        if($this->price_from) {
            $query->andWhere(['>=','price', $this->price_from]);
        }
        if($this->price_to) {
            $query->andWhere(['<=','price', $this->price_to]);
        }
        if($this->residential_сomplex_id) {
            $query->andWhere(['in','residential_сomplex_id', $this->residential_сomplex_id]);
        }

        if($this->area_from) {
            $query->andWhere(['>=','area', $this->area_from]);
        }
        if($this->metro) {
            $query->andWhere(['like','metro', '"name":"'.$this->metro.'",']);
        }
        if($this->area_to) {
            $query->andWhere(['<=','area', $this->area_to]);
        }

        if($this->district) {
            $query->andWhere(['in', 'district', $this->district]);
        }
        if($this->type) {
            $query->andWhere(['in', 'type', $this->type]);
        }
        if($this->saleType) {
            $query->andWhere(['=', 'saleType', $this->saleType]);
        }
        if($this->user_id) {
            $query->andWhere(['=', 'user_id', $this->user_id]);
        }
        // echo "<pre>";
        // print_r($this->residential_сomplex_id);
        if($returnQuery) return $query;
        return $dataProvider;
    }
}
