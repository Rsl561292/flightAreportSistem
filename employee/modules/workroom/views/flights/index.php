<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;
use common\models\Flights;
use common\models\Airports;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Польоти';
$this->params['breadcrumbs'][] = $this->title;
$this->params['inscription_object_title'] = 'Польоти';
$this->params['inscription_object_explanation'] = 'Список польотів';

?>

<div class="flights-index">

    <div class="row">
        <div class="col-xs-12">
            <div class="portlet light bg-inverse block-border-top-3x-primary">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-list-alt"></i> <?= $this->params['inscription_object_explanation']?>
                    </div>
                    <div class="actions btn-set">
                        <?= Html::a('Додати інформацію про новий політ', ['create'], ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>

                <div class="portlet-body">
                    <div class="table-responsive table-products">
                        <?php
                        Pjax::begin([
                            'id' => 'flights-grid',
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
                                    'content' => function($model) {
                                        return $model->id;
                                    },
                                    'filter' => Html::activeTextInput($searchModel, 'id', [
                                        'class' => 'form-control form-filter input-sm',
                                        'placeholder' => $searchModel->getAttributeLabel('id'),
                                    ]),
                                ],
                                [
                                    'attribute' => 'datetime_plane',
                                    'content' => function($model) {
                                        return $model->datetime_plane;
                                    },
                                    'filter' => false,
                                ],
                                [
                                    'attribute' => 'type',
                                    'content' => function($model) {
                                        return $model->getTypeName();
                                    },
                                    'filter' => Html::activeDropDownList($searchModel, 'type', Flights::getTypeList(), [
                                        'class' => 'form-control form-filter input-sm',
                                        'prompt' => '- Всі типи перевезень -'
                                    ]),
                                ],
                                [
                                    'attribute' => 'direction',
                                    'content' => function($model) {
                                        return $model->getDirectionName();
                                    },
                                    'filter' => Html::activeDropDownList($searchModel, 'direction', Flights::getDirectionList(), [
                                        'class' => 'form-control form-filter input-sm',
                                        'prompt' => '- Всі види напрямів -'
                                    ]),
                                ],
                                [
                                    'attribute' => 'airport_id',
                                    'content' => function($model) {
                                        return !empty($model->airport) ? Html::encode($model->airport->name) : '';
                                    },
                                    'filter' => Html::activeDropDownList($searchModel, 'airport_id', Airports::getActiveRecordListId(), [
                                        'class' => 'form-control form-filter input-sm',
                                        'prompt' => '- Всі аеропорти -'
                                    ]),
                                ],
                                [
                                    'attribute' => 'status',
                                    'content' => function($model) {

                                        return $model->getStatusName();
                                    },
                                    'filter' => Html::activeDropDownList($searchModel, 'status', Flights::getStatusList(), [
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