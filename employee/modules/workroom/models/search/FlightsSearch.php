<?php

namespace employee\modules\workroom\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Flights;

/**
 * FlightsSearch represents the model behind the search form about `common\models\Flights.
 */
class FlightsSearch extends Flights
{

    public $pageSize;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['datetime_plane', 'datetime_fact', 'begin_registration_plan', 'end_registration_plan', 'begin_registration_fact', 'end_registration_fact', 'begin_landing_plan', 'end_landing_plan', 'begin_landing_fact', 'end_landing_fact'], 'safe'],
            [['pageSize', 'plane_id', 'strip_id', 'airport_id'], 'integer'],
            [['type', 'direction', 'status', 'visible'], 'string', 'max' => 1],
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
        $query = Carrier::find()
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
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'identification_code', $this->identification_code])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'other_address', $this->other_address])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'short_description', $this->short_description])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }

}
