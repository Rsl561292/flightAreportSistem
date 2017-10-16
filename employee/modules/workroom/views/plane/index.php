<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;
use common\models\Plane;
use common\models\TypesPlanes;
use common\models\Carrier;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Повітряні судна';
$this->params['breadcrumbs'][] = $this->title;
$this->params['inscription_object_title'] = 'Повітряні судна';
$this->params['inscription_object_explanation'] = 'Список повітряних суден';

?>

<div class="plane-index">

    <div class="row">
        <div class="col-xs-12">
            <div class="portlet light bg-inverse block-border-top-3x-primary">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-list-alt"></i> <?= $this->params['inscription_object_explanation']?>
                    </div>
                    <div class="actions btn-set">
                        <?= Html::a('Додати нове ПС', ['create'], ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>

                <div class="portlet-body">
                    <div class="table-responsive table-products">
                        <?php
                        Pjax::begin([
                            'id' => 'plane-grid',
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
                                    'headerOptions' => ['width' => '10%'],
                                    'template' => '{delete} {update} {view}',
                                    'header' => Html::a('<i class="fa fa-refresh"></i> Оновити', ['index'], ['class' => 'btn red']),
                                    'contentOptions' => ['class' => 'action-column'],
                                ],
                                [
                                    'attribute' => 'registration_code',
                                    'headerOptions' => ['width' => '30%'],
                                    'content' => function($model) {
                                        return Html::encode($model->registration_code);
                                    },
                                    'filter' => Html::activeTextInput($searchModel, 'registration_code', [
                                        'class' => 'form-control form-filter input-sm',
                                        'placeholder' => $searchModel->getAttributeLabel('registration_code'),
                                    ]),
                                ],
                                [
                                    'attribute' => 'type_id',
                                    'headerOptions' => ['width' => '20%'],
                                    'content' => function($model) {
                                        return !empty($model->type) ? Html::encode($model->type->full_name_type) : '';
                                    },
                                    'filter' => Html::activeDropDownList($searchModel, 'type_id', TypesPlanes::getAllRecordListId(), [
                                        'class' => 'form-control form-filter input-sm',
                                        'prompt' => '- Всі типи -'
                                    ]),
                                ],
                                [
                                    'attribute' => 'carrier_id',
                                    'headerOptions' => ['width' => '20%'],
                                    'content' => function($model) {
                                        return !empty($model->carrier) ? Html::encode($model->carrier->name) : '';
                                    },
                                    'filter' => Html::activeDropDownList($searchModel, 'carrier_id', Carrier::getAllRecordListId(), [
                                        'class' => 'form-control form-filter input-sm',
                                        'prompt' => '- Всі власники -'
                                    ]),
                                ],
                                [
                                    'attribute' => 'status_location',
                                    'headerOptions' => ['width' => '10%'],
                                    'content' => function($model) {
                                        $class = 'label-primary';

                                        switch ($model->status_location) {
                                            case Plane::STATUS_LOCATION_IN_AREPORT:
                                                $class = 'label-success';
                                                break;
                                            case Plane::STATUS_LOCATION_NOT_IN_AREPORT:
                                                $class = 'label-danger';
                                                break;
                                        }

                                        return Html::tag('span', $model->getStatusLocationName(), ['class' => 'label label-sm ' . $class]);
                                    },
                                    'filter' => Html::activeDropDownList($searchModel, 'status_location', Plane::getStatusLocationList(), [
                                        'class' => 'form-control form-filter input-sm',
                                        'prompt' => '- Всі види розміщення -'
                                    ]),
                                ],
                                [
                                    'attribute' => 'status_preparation',
                                    'headerOptions' => ['width' => '10%'],
                                    'content' => function($model) {
                                        $class = 'label-primary';

                                        switch ($model->status_preparation) {
                                            case Plane::STATUS_PREPARATION_IN_WORKING:
                                                $class = 'label-success';
                                                break;
                                            case Plane::STATUS_PREPARATION_NEED_REPAIR:
                                                $class = 'label-danger';
                                                break;
                                            case Plane::STATUS_PREPARATION_NEED_TECHNICAL_CHECK:
                                                $class = 'label-warning';
                                                break;
                                        }

                                        return Html::tag('span', $model->getStatusPreparationName(), ['class' => 'label label-sm ' . $class]);
                                    },
                                    'filter' => Html::activeDropDownList($searchModel, 'status_preparation', Plane::getStatusPreparationList(), [
                                        'class' => 'form-control form-filter input-sm',
                                        'prompt' => '- Всі стани -'
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