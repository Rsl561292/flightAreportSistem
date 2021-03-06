<?php

namespace employee\modules\workroom\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\RegistrationDeskToFlight;

/**
 * RegistrationDeskToFlightSearch represents the model behind the search form about `common\models\RegistrationDeskToFlight`.
 */
class RegistrationDeskToFlightSearch extends RegistrationDeskToFlight
{

    public $pageSize;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'pageSize', 'flight_id', 'registration_desk_id'], 'integer'],
            [['class'], 'string', 'max' => 1],
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
        $query = RegistrationDeskToFlight::find()
            ->with([
                'flight',
                'registrationDesk',
            ]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'flight_id' => SORT_ASC,
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
            'flight_id' => $this->flight_id,
            'registration_desk_id' => $this->registration_desk_id,
            'class' => $this->class,
        ]);

        return $dataProvider;
    }

}
