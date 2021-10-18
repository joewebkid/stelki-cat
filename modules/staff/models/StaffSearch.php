<?php

namespace app\modules\staff\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\staff\models\Staff;

/**
 * StaffSearch represents the model behind the search form about `app\modules\staff\models\Staff`.
 */
class StaffSearch extends Staff
{
    public static function tableName()
    {
        return 'staff';
    }

    public function rules()
    {
        return [
            [['id', 'login', 'pwhash'], 'safe'],
            [['status', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Staff::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'login', $this->login])
            ->andFilterWhere(['like', 'pwhash', $this->pwhash]);

        return $dataProvider;
    }
}
