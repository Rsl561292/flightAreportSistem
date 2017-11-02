<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;
use common\models\ScheduleBusyPlatform;
use common\models\Platform;
use common\models\Plane;
use common\models\Flights;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Графіки зайнятості перону';
$this->params['breadcrumbs'][] = $this->title;
$this->params['inscription_object_title'] = 'Графіки зайнятості перону';
$this->params['inscription_object_explanation'] = 'Список графіків';

?>

<div class="schedule-busy-platform-index">

    <div class="row">
        <div class="col-xs-12">
            <div class="portlet light bg-inverse block-border-top-3x-primary">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-list-alt"></i> <?= $this->params['inscription_object_explanation']?>
                    </div>
                    <div class="actions btn-set">
                        <?= Html::a('Додати запис графіку', ['create'], ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>

                <div class="portlet-body">
                    <div class="table-responsive table-products">
                        <?php
                        Pjax::begin([
                            'id' => 'schedule-busy-platform-grid',
                            'timeout' => false,
                            'enablePushState' => false,
                            'clientOptions' => [
                                'method' => 'get',
                            ],
                        ]);

                        echo GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'filterSelector' => '#' . Html::getInputId($searchModel, 'pageSize'),
                            'options' => [
                                'class' => 'table table-bordered table-hover',
                            ],
                            'columns' => [
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'template' => '{delete} {update} {view}',
                                    'header' => Html::a('<i class="fa fa-refresh"></i> Оновити', ['index'], ['class' => 'btn red']),
                                    'contentOptions' => ['class' => 'action-column'],
                                ],
                                [
                                    'attribute' => 'id',
                                    'headerOptions' => ['width' => '70'],
                                    'content' => function($model) {
                                        return $model->id;
                                    },
                                    'filter' => Html::activeTextInput($searchModel, 'id', [
                                        'class' => 'form-control form-filter input-sm',
                                        'placeholder' => $searchModel->getAttributeLabel('id'),
                                    ]),
                                ],
                                [
                                    'attribute' => 'platform_id',
                                    'headerOptions' => ['width' => '80'],
                                    'content' => function($model) {
                                        return !empty($model->platform) ? Html::encode($model->platform->symbol) : '';
                                    },
                                    'filter' => Html::activeDropDownList($searchModel, 'platform_id', Platform::getAllRecordListId(), [
                                        'class' => 'form-control form-filter input-sm',
                                        'prompt' => '- Всі перони -'
                                    ]),
                                ],
                                [
                                    'attribute' => 'begin_busy_plan',
                                    'headerOptions' => ['width' => '150'],
                                    'content' => function($model) {
                                        return $model->begin_busy_plan;
                                    },
                                    'filter' => false,
                                ],
                                [
                                    'attribute' => 'end_busy_plan',
                                    'headerOptions' => ['width' => '150'],
                                    'content' => function($model) {
                                        return $model->end_busy_plan;
                                    },
                                    'filter' => false,
                                ],
                                [
                                    'attribute' => 'plane_id',
                                    'headerOptions' => ['width' => '120'],
                                    'content' => function($model) {
                                        return !empty($model->plane) ? Html::encode($model->plane->registration_code) : '';
                                    },
                                    'filter' => Html::activeDropDownList($searchModel, 'plane_id', Plane::getAllRecordListId(), [
                                        'class' => 'form-control form-filter input-sm',
                                        'prompt' => '- Всі ПС -'
                                    ]),
                                ],
                                [
                                    'attribute' => 'flight_id',
                                    'headerOptions' => ['width' => '250'],
                                    'content' => function($model) {
                                        return !empty($model->flight) ? $model->flight->id.' : '.$model->flight->getDirectionName().', '.$model->flight->getStatusName().' в '.date('Y-m-d H:i', strtotime($model->flight->datetime_fact)) : '';
                                    },
                                    'filter' => Html::activeDropDownList($searchModel, 'flight_id', Flights::getAllRecordListId(), [
                                        'class' => 'form-control form-filter input-sm',
                                        'prompt' => '- Всі польоти -'
                                    ]),
                                ],
                                [
                                    'attribute' => 'status',
                                    'headerOptions' => ['width' => '100'],
                                    'content' => function($model) {
                                        $class = 'label-default';

                                        switch ($model->status) {
                                            case ScheduleBusyPlatform::STATUS_SCHEDULED:
                                                $class = 'label-warning';
                                                break;
                                            case ScheduleBusyPlatform::STATUS_USED:
                                                $class = 'label-primary';
                                                break;
                                            case ScheduleBusyPlatform::STATUS_COMPLETED:
                                                $class = 'label-success';
                                                break;
                                            case ScheduleBusyPlatform::STATUS_CANCELED:
                                                $class = 'label-danger';
                                                break;
                                        }

                                        return Html::tag('span', $model->getStatusName(), ['class' => 'label label-sm ' . $class]);
                                    },
                                    'filter' => Html::activeDropDownList($searchModel, 'status', ScheduleBusyPlatform::getStatusList(), [
                                        'class' => 'form-control form-filter input-sm',
                                        'prompt' => '- Статус -'
                                    ]),
                                ],
                            ],
                        ]);
                        Pjax::end();
                        ?>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <!-- /.col -->
    </div>
</div>