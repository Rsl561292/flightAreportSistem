<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Flights */


$this->title = 'Перегляд запису';
$this->params['breadcrumbs'][] = ['label' => 'Польоти', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['inscription_object_title'] = 'Польоти';
$this->params['inscription_object_explanation'] = 'Перегляд запису';
?>

<div class="flights-view">

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
                                'id',
                                [
                                    'attribute' => 'type',
                                    'value' => function($model) {
                                        return $model->getTypeName();
                                    },
                                ],
                                [
                                    'attribute' => 'direction',
                                    'value' => function($model) {
                                        return $model->getDirectionName();
                                    },
                                ],
                                [
                                    'attribute' => 'status',
                                    'value' => function($model) {
                                        return $model->getStatusName();
                                    },
                                ],
                                [
                                    'attribute' => 'visible',
                                    'value' => function($model) {
                                        return $model->getVisibleName();
                                    },
                                ],
                                'datetime_plane',
                                'datetime_fact',
                                [
                                    'attribute' => 'plane_id',
                                    'value' => function($model) {
                                        return !empty($model->plane) ? Html::encode($model->plane->registration_code) : '';
                                    },
                                ],
                                [
                                    'attribute' => 'strip_id',
                                    'value' => function($model) {
                                        return !empty($model->strip) ? Html::encode($model->strip->marking) : '';
                                    },
                                ],
                                [
                                    'attribute' => 'airport_id',
                                    'value' => function($model) {
                                        return !empty($model->airport) ? Html::encode($model->airport->name) : '';
                                    },
                                ],
                                'begin_registration_plan',
                                'end_registration_plan',
                                'begin_registration_fact',
                                'end_registration_fact',
                                'begin_landing_plan',
                                'end_landing_plan',
                                'begin_landing_fact',
                                'end_landing_fact',
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
