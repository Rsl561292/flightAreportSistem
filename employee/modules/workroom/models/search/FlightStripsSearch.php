<?php

namespace employee\modules\workroom\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\FlightStrips;

/**
 * FlightStripsSearch represents the model behind the search form about `common\models\FlightStrips.
 */
class FlightStripsSearch extends FlightStrips
{

    public $pageSize;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'length_NDR',
                    'bias_threshold',
                    'length_KSH',
                    'length_KZB',
                    'length_VZ',
                    'width',
                    'width_sidebar_safety'
                ], 'number'
            ],
            [['description'], 'string'],
            [['user_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['marking'], 'string', 'max' => 15],
            [['surface', 'category'], 'string', 'max' => 1],
            [['status'], 'string', 'max' => 2],
            [['marking'], 'unique'],
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
        $query = Plane::find()
            ->with([
                'type',
                'carrier',
            ]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'registration_code' => SORT_ASC,
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
            'type_id' => $this->type_id,
            'carrier_id' => $this->carrier_id,
            'status_location' => $this->status_location,
            'status_preparation' => $this->status_preparation,

        ]);

        $query->andFilterWhere(['like', 'registration_code', $this->registration_code]);

        return $dataProvider;
    }

}
