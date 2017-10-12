<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;
use common\models\GisCountry;
use common\models\GisRegions;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Авіаперевізники';
$this->params['breadcrumbs'][] = $this->title;
$this->params['inscription_object_title'] = 'Авіаперевізники';
$this->params['inscription_object_explanation'] = 'Список авіаперевізників';

?>

<div class="regions-index">

    <div class="row">
        <div class="col-xs-12">
            <div class="portlet light bg-inverse block-border-top-3x-primary">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-list-alt"></i> <?= $this->params['inscription_object_explanation']?>
                    </div>
                    <div class="actions btn-set">
                        <?= Html::a('Додати нового авіаперевізника', ['create'], ['class' => 'btn btn-primary']) ?>
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
                                    'attribute' => 'identification_code',
                                    'label' => 'Ідент. коде',
                                    'content' => function($model) {
                                        return $model->identification_code;
                                    },
                                    'filter' => Html::activeTextInput($searchModel, 'identification_code', [
                                        'class' => 'form-control form-filter input-sm',
                                        'placeholder' => $searchModel->getAttributeLabel('identification_code'),
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
                                        return Html::encode($model->country->name);
                                    },
                                    'filter' => Html::activeDropDownList($searchModel, 'country_id', GisCountry::getActiveCountryListId(), [
                                        'class' => 'form-control form-filter input-sm',
                                        'prompt' => '- Країна -'
                                    ]),
                                ],
                                [
                                    'attribute' => 'status',
                                    'content' => function($model) {
                                        $class = 'label-primary';

                                        switch ($model->status) {
                                            case GisRegions::STATUS_ACTIVE:
                                                $class = 'label-success';
                                                break;
                                            case GisRegions::STATUS_INACTIVE:
                                                $class = 'label-danger';
                                                break;
                                        }

                                        return Html::tag('span', $model->getStatusName(), ['class' => 'label label-sm ' . $class]);
                                    },
                                    'filter' => Html::activeDropDownList($searchModel, 'status', GisRegions::getStatusList(), [
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