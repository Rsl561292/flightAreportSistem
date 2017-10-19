<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;
use common\models\FlightStrips;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Льотні смуги';
$this->params['breadcrumbs'][] = $this->title;
$this->params['inscription_object_title'] = 'Льотні смуги';
$this->params['inscription_object_explanation'] = 'Список льотних смуг';

?>

<div class="flight-strips-index">

    <div class="row">
        <div class="col-xs-12">
            <div class="portlet light bg-inverse block-border-top-3x-primary">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-list-alt"></i> <?= $this->params['inscription_object_explanation']?>
                    </div>
                    <div class="actions btn-set">
                        <?= Html::a('Додати нову льотну смугу', ['create'], ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>

                <div class="portlet-body">
                    <div class="table-responsive table-products">
                        <?php
                        Pjax::begin([
                            'id' => 'flight-strips-grid',
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
                                    'attribute' => 'name',
                                    'headerOptions' => ['width' => '30%'],
                                    'content' => function($model) {
                                        return Html::encode($model->name);
                                    },
                                    'filter' => Html::activeTextInput($searchModel, 'name', [
                                        'class' => 'form-control form-filter input-sm',
                                        'placeholder' => $searchModel->getAttributeLabel('name'),
                                    ]),
                                ],
                                [
                                    'attribute' => 'marking',
                                    'headerOptions' => ['width' => '15%'],
                                    'content' => function($model) {
                                        return Html::encode($model->marking);
                                    },
                                    'filter' => Html::activeTextInput($searchModel, 'marking', [
                                        'class' => 'form-control form-filter input-sm',
                                        'placeholder' => $searchModel->getAttributeLabel('marking'),
                                    ]),
                                ],
                                [
                                    'attribute' => 'surface',
                                    'headerOptions' => ['width' => '15%'],
                                    'content' => function($model) {
                                        return $model->getSurfaceName();
                                    },
                                    'filter' => Html::activeDropDownList($searchModel, 'surface', FlightStrips::getSurfaceList(), [
                                        'class' => 'form-control form-filter input-sm',
                                        'prompt' => '- Всі покриття -'
                                    ]),
                                ],
                                [
                                    'attribute' => 'category',
                                    'headerOptions' => ['width' => '15%'],
                                    'content' => function($model) {
                                        return $model->getCategoryName();
                                    },
                                    'filter' => Html::activeDropDownList($searchModel, 'category', FlightStrips::getCategoryList(), [
                                        'class' => 'form-control form-filter input-sm',
                                        'prompt' => '- Всі категорії -'
                                    ]),
                                ],
                                [
                                    'attribute' => 'status',
                                    'headerOptions' => ['width' => '15%'],
                                    'content' => function($model) {
                                        $class = 'label-primary';

                                        switch ($model->status) {
                                            case FlightStrips::STATUS_ACTIVE:
                                                $class = 'label-success';
                                                break;
                                            case FlightStrips::STATUS_INACTIVE:
                                                $class = 'label-danger';
                                                break;
                                        }

                                        return Html::tag('span', $model->getStatusName(), ['class' => 'label label-sm ' . $class]);
                                    },
                                    'filter' => Html::activeDropDownList($searchModel, 'status', FlightStrips::getStatusList(), [
                                        'class' => 'form-control form-filter input-sm',
                                        'prompt' => '- Всі типи -'
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