<?php

namespace employee\modules\workroom\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\RegistrationDesk;

/**
 * TerminalsSearch represents the model behind the search form about `common\models\Terminals`.
 */
class RegistrationDeskSearch extends RegistrationDesk
{

    public $pageSize;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'pageSize'], 'integer'],
            [['area'], 'number'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['symbol', 'status'], 'string', 'max' => 2],
            ['year_built', 'date'],
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
        $query = Terminals::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
            'sort' => [
                'defaultOrder' => [
                    'symbol' => SORT_ASC,
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
            'status' => $this->status,
            'symbol' => $this->symbol,
            'area' => $this->area,
            'year_built' => $this->year_built,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }

}
