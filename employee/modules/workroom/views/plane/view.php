<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\TypesPlanes */


$this->title = 'Перегляд запису';
$this->params['breadcrumbs'][] = ['label' => 'Моделі ПС', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['inscription_object_title'] = 'Моделі ПС';
$this->params['inscription_object_explanation'] = 'Перегляд запису';
?>

<div class="plane-types-view">

    <div class="row">
        <div class="col-xs-12">
            <div class="portlet light bg-inverse block-border-top-3x-primary">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-list-alt"></i> <?= $this->params['inscription_object_explanation']?>
                    </div>
                    <div class="actions btn-set">
                        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Ви впевнені, що хочете видалити цей запис?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </div>
                </div>

                <div class="portlet-body">
                    <div class="table-responsive table-products">
                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                'full_name_type',
                                'marking',
                                [
                                    'attribute' => 'kind',
                                    'value' => function($model) {
                                        return $model->getKindName();
                                    },
                                ],
                                [
                                    'attribute' => 'category_plane',
                                    'value' => function($model) {
                                        return $model->getCategoryName();
                                    },
                                ],
                                'length',
                                'wingspan',
                                'need_length_trip',
                                'weight_empty_plane',
                                'height_fuselage',
                                'width_fuselage',
                                'height_salon',
                                'width_salon',
                                'max_take_off_mass',
                                'max_load',
                                'cruising_speed',
                                'max_speed',
                                'cruising_height',
                                'max_height',
                                'max_distance_empty',
                                'distance_one_load',
                                'max_stock_fuel',
                                'fuel_costs_empty',
                                'fuel_costs_unit_weight',
                                'max_number_seats',
                                'seats_business_class',
                                'count_crew',
                                'comment',
                                'created_at',
                                'updated_at',
                            ],
                        ]) ?>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <!-- /.col -->
    </div>
</div>
