<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ScheduleBusyPlatform */


$this->title = 'Перегляд запису';
$this->params['breadcrumbs'][] = ['label' => 'Графіки зайнятості перону', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['inscription_object_title'] = 'Графіки зайнятості перону';
$this->params['inscription_object_explanation'] = 'Перегляд запису';
?>

<div class="schedule-busy-platform-view">

    <div class="row">
        <div class="col-xs-12">
            <div class="portlet light bg-inverse block-border-top-3x-primary">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-list-alt"></i> <?= $this->params['inscription_object_explanation']?>
                    </div>
                    <div class="actions btn-set">
                        <?= Html::a('Редагувати', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('Видалити', ['delete', 'id' => $model->id], [
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
                                    'attribute' => 'platform_id',
                                    'value' => function($model) {
                                        return !empty($model->platform) ? Html::encode($model->platform->symbol) : '';
                                    },
                                ],
                                [
                                    'attribute' => 'plane_id',
                                    'value' => function($model) {
                                        return !empty($model->plane) ? Html::encode($model->plane->registration_code) : '';
                                    },
                                ],
                                [
                                    'attribute' => 'flight_id',
                                    'value' => function($model) {
                                        return !empty($model->flight) ? $model->flight->id.' : '.$model->flight->getDirectionName().', '.$model->flight->getStatusName().' в '.date('Y-m-d H:i', strtotime($model->flight->datetime_fact)) : '';
                                    },
                                ],
                                [
                                    'attribute' => 'time_plan',
                                    'label' => 'Період займання по плану',
                                    'value' => function($model) {
                                        return 'з '.date('Y-m-d H:i', strtotime($model->begin_busy_plan)).' по '.date('Y-m-d H:i', strtotime($model->end_busy_plan));
                                    },
                                ],
                                [
                                    'attribute' => 'time_fact',
                                    'label' => 'Період займання по факту',
                                    'value' => function($model) {
                                        return 'з '.($model->begin_busy_fact == null ? date('Y-m-d H:i', strtotime($model->begin_busy_fact)) : '--').' по '.($model->end_busy_fact == null ? date('Y-m-d H:i', strtotime($model->end_busy_fact)) : '--');
                                    },
                                ],
                                [
                                    'attribute' => 'status',
                                    'value' => function($model) {
                                        return $model->getStatusName();
                                    },
                                ],
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
