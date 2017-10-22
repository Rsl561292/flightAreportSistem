<?php

namespace employee\modules\workroom\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Airports;

/**
 * AirportsSearch represents the model behind the search form about `common\models\Airports.
 */
class AirportsSearch extends Airports
{

    public $pageSize;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'pageSize', 'country_id', 'region_id', 'commandant_time', 'user_id'], 'integer'],
            [['distance_to_airport'], 'number'],
            [['code_iata', 'code_ikao'], 'string', 'max' => 4],
            [['code_iata'], 'unique'],
            [['name', 'city', 'other_address'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 2],
            [['begin_commandant_time', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    public function init()
    {
        
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Airports::find()
            ->with([
                'country'
            ]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'name' => SORT_ASC,
                ],
            ],
        ]);

        $this->load($params);

        $dataProvider->pagination->pageSize = $this->pageSize !== null ? $this->pageSize : Yii::$app->params['employee.gridView.pagination.pageSizeLimit.default'];

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'country_id' => $this->country_id,
            'region_id' => $this->region_id,
            'distance_to_airport' => $this->distance_to_airport,
            'begin_commandant_time' => $this->begin_commandant_time,
            'commandant_time' => $this->commandant_time,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'code_iata', $this->code_iata])
            ->andFilterWhere(['like', 'code_ikao', $this->code_ikao])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'other_address', $this->other_address]);

        return $dataProvider;
    }

}
