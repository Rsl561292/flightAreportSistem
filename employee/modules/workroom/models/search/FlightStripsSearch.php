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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['marking'], 'string', 'max' => 15],
            [['surface', 'category'], 'string', 'max' => 1],
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
            [['status'], 'string', 'max' => 2],
            [['description'], 'string'],
            [['user_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
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
        $query = FlightStrips::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' =>false,
            'sort' => [
                'defaultOrder' => [
                    'marking' => SORT_ASC,
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'surface' => $this->surface,
            'length_NDR' => $this->length_NDR,
            'bias_threshold' => $this->bias_threshold,
            'length_KSH' => $this->length_KSH,
            'length_KZB' => $this->length_KZB,
            'length_VZ' => $this->length_VZ,
            'width' => $this->width,
            'width_sidebar_safety' => $this->width_sidebar_safety,
            'status' => $this->status,
            'category' => $this->category,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'marking', $this->marking])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }

}
