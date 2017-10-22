<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;
use common\models\GisCountry;
use common\models\GisRegions;
use common\models\Airports;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Аеропорти';
$this->params['breadcrumbs'][] = $this->title;
$this->params['inscription_object_title'] = 'Аеропорти';
$this->params['inscription_object_explanation'] = 'Список аеропортів';

?>

<div class="airports-index">

    <div class="row">
        <div class="col-xs-12">
            <div class="portlet light bg-inverse block-border-top-3x-primary">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-list-alt"></i> <?= $this->params['inscription_object_explanation']?>
                    </div>
                    <div class="actions btn-set">
                        <?= Html::a('Додати новий аеропорт', ['create'], ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>

                <div class="portlet-body">
                    <div class="table-responsive table-products">
                        <?php
                        Pjax::begin([
                            'id' => 'airports-grid',
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
                                    'attribute' => 'code_iata',
                                    'content' => function($model) {
                                        return $model->code_iata;
                                    },
                                    'filter' => Html::activeTextInput($searchModel, 'code_iata', [
                                        'class' => 'form-control form-filter input-sm',
                                        'placeholder' => $searchModel->getAttributeLabel('code_iata'),
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
                                    'attribute' => 'country_id',
                                    'content' => function($model) {
                                        return !empty($model->country) ? Html::encode($model->country->name) : '';
                                    },
                                    'filter' => Html::activeDropDownList($searchModel, 'country_id', GisCountry::getActiveCountryListId(), [
                                        'class' => 'form-control form-filter input-sm',
                                        'prompt' => '- Всі країни -'
                                    ]),
                                ],
                                [
                                    'attribute' => 'status',
                                    'content' => function($model) {
                                        $class = 'label-primary';

                                        switch ($model->status) {
                                            case Airports::STATUS_OPEN:
                                                $class = 'label-success';
                                                break;
                                            case Airports::STATUS_CLOSE:
                                                $class = 'label-danger';
                                                break;
                                        }

                                        return Html::tag('span', $model->getStatusName(), ['class' => 'label label-sm ' . $class]);
                                    },
                                    'filter' => Html::activeDropDownList($searchModel, 'status', GisRegions::getStatusList(), [
                                        'class' => 'form-control form-filter input-sm',
                                        'prompt' => '- Всі статуси -'
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