<?php

namespace employee\modules\workroom\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TypesPlanes;

/**
 * PlaneTypesSearch represents the model behind the search form about `common\models\TypesPlanes.
 */
class PlaneTypesSearch extends TypesPlanes
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
                    'length', 'wingspan', 'wing_area', 'width_chassis', 'length_take_off',
                    'length_landing', 'weight_empty_plane', 'height_fuselage',
                    'width_fuselage', 'height_salon', 'width_salon', 'max_take_off_mass',
                    'max_load', 'cruising_speed', 'max_speed', 'max_distance_empty',
                    'distance_one_load', 'max_stock_fuel', 'fuel_costs_empty',
                    'fuel_costs_unit_weight'
                ],
                'number'
            ],
            [
                [
                    'cruising_height', 'max_height',
                    'max_number_seats', 'seats_business_class', 'count_crew'
                ],
                'integer'
            ],
            [['full_name_type'], 'string', 'max' => 255],
            [['full_name_type'], 'unique'],
            [['marking'], 'string', 'max' => 30],
            [['kind'], 'string', 'max' => 1],
            [['comment'], 'string'],
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
        $query = TypesPlanes::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'full_name_type' => SORT_ASC,
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
            'kind' => $this->kind,
            'length' => $this->length,
            'wingspan' => $this->wingspan,
            'wing_area' => $this->wing_area,
            'width_chassis' => $this->width_chassis,
            'length_take_off' => $this->length_take_off,
            'length_landing' => $this->length_landing,
            'weight_empty_plane' => $this->weight_empty_plane,
            'height_fuselage' => $this->height_fuselage,
            'width_fuselage' => $this->width_fuselage,
            'height_salon' => $this->height_salon,
            'width_salon' => $this->width_salon,
            'max_take_off_mass' => $this->max_take_off_mass,
            'max_load' => $this->max_load,
            'cruising_speed' => $this->cruising_speed,
            'max_speed' => $this->max_speed,
            'cruising_height' => $this->cruising_height,
            'max_height' => $this->max_height,
            'max_distance_empty' => $this->max_distance_empty,
            'distance_one_load' => $this->distance_one_load,
            'max_stock_fuel' => $this->max_stock_fuel,
            'fuel_costs_empty' => $this->fuel_costs_empty,
            'fuel_costs_unit_weight' => $this->fuel_costs_unit_weight,
            'max_number_seats' => $this->max_number_seats,
            'seats_business_class' => $this->seats_business_class,
            'count_crew' => $this->count_crew,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'full_name_type', $this->full_name_type])
            ->andFilterWhere(['like', 'marking', $this->marking])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }

}
