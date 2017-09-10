<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;
use common\models\Terminals;
use common\models\Platform;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Посад. платформи';
$this->params['breadcrumbs'][] = $this->title;
$this->params['inscription_object_title'] = 'Посад. платформи';
$this->params['inscription_object_explanation'] = 'Список посад. платформ';
?>
<div class="registration-desk-index">

    <div class="row">
        <div class="col-xs-12">
            <div class="portlet light bg-inverse block-border-top-3x-primary">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-list-alt"></i> <?= $this->params['inscription_object_explanation']?>
                    </div>
                    <div class="actions btn-set">
                        <?= Html::a('Додати нову платформу', ['create'], ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>

                <div class="portlet-body">
                    <div class="table-responsive table-products">
                        <?php
                        Pjax::begin([
                            'id' => 'registration-desk-grid',
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
                                    'template' => '{delete} {update}',
                                    'header' => Html::a('<i class="fa fa-refresh"></i> Оновити', ['index'], ['class' => 'btn red']),
                                    'contentOptions' => ['class' => 'action-column'],
                                ],
                                [
                                    'attribute' => 'symbol',
                                    'label' => 'Позн.',
                                    'content' => function($model) {
                                        return $model->symbol;
                                    },
                                    'filter' => Html::activeTextInput($searchModel, 'symbol', [
                                        'class' => 'form-control form-filter input-sm',
                                        'placeholder' => $searchModel->getAttributeLabel('symbol'),
                                    ]),

                                ],
                                [
                                    'attribute' => 'name',
                                    'content' => function($model) {
                                        return $model->name;
                                    },
                                    'filter' => Html::activeTextInput($searchModel, 'name', [
                                        'class' => 'form-control form-filter input-sm',
                                        'placeholder' => $searchModel->getAttributeLabel('name'),
                                    ]),

                                ],
                                [
                                    'attribute' => 'terminal_id',
                                    'label' => 'Терм',
                                    'content' => function($model) {
                                        return $model->terminal_id !== null? Html::encode($model->terminals->symbol) : '';
                                    },
                                    'filter' => Html::activeDropDownList($searchModel, 'terminal_id', Terminals::getTerminalsListAll(), [
                                        'class' => 'form-control form-filter input-sm',
                                        'prompt' => '- Термінал -'
                                    ]),

                                ],[
                                    'attribute' => 'type_connecting',
                                    'content' => function($model) {
                                        return $model->getTypeConnectingName();
                                    },
                                    'filter' => Html::activeDropDownList($searchModel, 'type_connecting', Platform::getTypeConnectingList(), [
                                        'class' => 'form-control form-filter input-sm',
                                        'prompt' => '- Тип стикування -'
                                    ]),
                                ],
                                [
                                    'attribute' => 'status',
                                    'content' => function($model) {
                                        $class = 'label-primary';

                                        switch ($model->status) {
                                            case Platform::STATUS_WORKING_AND_OPEN:
                                                $class = 'label-success';
                                                break;
                                            case Platform::STATUS_WORKING_AND_CLOSE:
                                                $class = 'label-warning';
                                                break;
                                            case Platform::STATUS_NOT_WORKING:
                                                $class = 'label-danger';
                                                break;
                                        }

                                        return Html::tag('span', $model->getStatusName(), ['class' => 'label label-sm ' . $class]);
                                    },
                                    'filter' => Html::activeDropDownList($searchModel, 'status', Platform::getStatusList(), [
                                        'class' => 'form-control form-filter input-sm',
                                        'prompt' => '- Статус -'
                                    ]),
                                ],
                                [
                                    'attribute' => 'width',
                                    'content' => function($model) {
                                        return $model->width;
                                    },
                                    'filter' => Html::activeTextInput($searchModel, 'width', [
                                        'class' => 'form-control form-filter input-sm',
                                        'placeholder' => $searchModel->getAttributeLabel('width'),
                                    ]),

                                ],
                                [
                                    'attribute' => 'length',
                                    'content' => function($model) {
                                        return $model->length;
                                    },
                                    'filter' => Html::activeTextInput($searchModel, 'length', [
                                        'class' => 'form-control form-filter input-sm',
                                        'placeholder' => $searchModel->getAttributeLabel('length'),
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
