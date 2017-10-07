<?php

namespace employee\modules\workroom\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\GisCountry;

/**
 * CountriesSearch represents the model behind the search form about `common\models\GisCountry.
 */
class CountriesSearch extends GisCountry
{

    public $pageSize;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code'], 'string', 'max' => 32],
            [['name', 'slug'], 'string', 'max' => 255],
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
        $query = GisCountry::find();

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
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'slug', $this->slug]);

        return $dataProvider;
    }

}
