<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;
use common\models\Terminals;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Термінали';
$this->params['breadcrumbs'][] = $this->title;
$this->params['inscription_object_title'] = 'Термінали';
$this->params['inscription_object_explanation'] = 'Список терміналів';
?>
<div class="terminals-index">

    <div class="row">
        <div class="col-xs-12">
            <div class="portlet light bg-inverse block-border-top-3x-primary">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-list-alt"></i> <?= $this->params['inscription_object_explanation']?>
                    </div>
                    <div class="actions btn-set">
                        <?= Html::a('Додати новий термінал', ['create'], ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>

                <div class="portlet-body">
                    <div class="table-responsive table-products">
                    <?php
                    Pjax::begin([
                        'id' => 'terminals-grid',
                        'timeout' => false,
                        'enablePushState' => false,
                        'clientOptions' => [
                            'method' => 'get',
                        ],
                    ]);

                    echo GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'filterSelector' => null,
                        'options' => [
                            'class' => 'table table-bordered table-hover',
                        ],
                        'columns' => [
                            [
                                'attribute' => 'symbol',
                                'headerOptions' => ['width' => '10%'],
                                'content' => function($model) {
                                    return $model->symbol;
                                },
                                'filter' => false,

                            ],
                            [
                                'attribute' => 'name',
                                'headerOptions' => ['width' => '50%'],
                                'content' => function($model) {
                                    return $model->name;
                                },
                                'filter' => false,

                            ],
                            [
                                'attribute' => 'year_built',
                                'label' => 'Побудовано',
                                'headerOptions' => ['width' => '10%'],
                                'content' => function($model) {
                                    return $model->year_built;
                                },
                                'filter' => false,

                            ],
                            [
                                'attribute' => 'area',
                                'headerOptions' => ['width' => '5%'],
                                'content' => function($model) {
                                    return $model->area;
                                },
                                'filter' => false,

                            ],
                            [
                                'attribute' => 'status',
                                'headerOptions' => ['width' => '15%'],
                                'content' => function($model) {
                                    $class = 'label-primary';

                                    switch ($model->status) {
                                        case Terminals::STATUS_OPEN:
                                            $class = 'label-success';
                                            break;
                                        case Terminals::STATUS_CLOSE:
                                            $class = 'label-danger';
                                            break;
                                        case Terminals::STATUS_RECONSTRUCTION:
                                            $class = 'label-warning';
                                            break;
                                    }

                                    return Html::tag('span', $model->getStatusName(), ['class' => 'label label-sm ' . $class]);
                                },
                                'filter' => false,
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{update} {delete}',
                                'header' => Html::a('<i class="fa fa-refresh"></i> Оновити', ['index'], ['class' => 'btn red']),
                                'headerOptions' => ['width' => '10%'],
                                'contentOptions' => ['class' => 'action-column'],
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
