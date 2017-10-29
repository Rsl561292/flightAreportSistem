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
            [['id', 'pageSize', 'plane_id', 'strip_id', 'airport_id'], 'integer'],
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
        $query = Flights::find()
            ->with([
                'airport'
            ]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'begin_registration_plan' => SORT_ASC,
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
            'id' => $this->id,
            'type' => $this->type,
            'direction' => $this->direction,
            'datetime_plane' => $this->datetime_plane,
            'datetime_fact' => $this->datetime_fact,
            'plane_id' => $this->plane_id,
            'strip_id' => $this->strip_id,
            'status' => $this->status,
            'visible' => $this->visible,
            'airport_id' => $this->airport_id,
            'begin_registration_plan' => $this->begin_registration_plan,
            'end_registration_plan' => $this->end_registration_plan,
            'begin_registration_fact' => $this->begin_registration_fact,
            'end_registration_fact' => $this->end_registration_fact,
            'begin_landing_plan' => $this->begin_landing_plan,
            'end_landing_plan' => $this->end_landing_plan,
            'begin_landing_fact' => $this->begin_landing_fact,
            'end_landing_fact' => $this->end_landing_fact,
        ]);

        return $dataProvider;
    }

}
