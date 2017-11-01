<?php

namespace employee\modules\workroom\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ScheduleBusyPlatform;

/**
 * ScheduleBusyPlatformSearch represents the model behind the search form about `common\models\ScheduleBusyPlatform.
 */
class ScheduleBusyPlatformSearch extends ScheduleBusyPlatform
{

    public $pageSize;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'pageSize', 'platform_id', 'plane_id', 'flight_id'], 'integer'],
            [['begin_busy_plan', 'end_busy_plan', 'begin_busy_fact', 'end_busy_fact'], 'safe'],
            [['status'], 'string', 'max' => 1],
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
        $query = ScheduleBusyPlatform::find()
            ->with([
                'platform',
                'plane',
                'flight'
            ]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'begin_busy_plan' => SORT_ASC,
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
            'platform_id' => $this->platform_id,
            'plane_id' => $this->plane_id,
            'flight_id' => $this->flight_id,
            'status' => $this->status,
            'begin_busy_plan' => $this->begin_busy_plan,
            'end_busy_plan' => $this->end_busy_plan,
            'begin_busy_fact' => $this->begin_busy_fact,
            'end_busy_fact' => $this->end_busy_fact,
        ]);

        return $dataProvider;
    }

}
