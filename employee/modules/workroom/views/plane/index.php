<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;
use common\models\TypesPlanes;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Моделі ПС';
$this->params['breadcrumbs'][] = $this->title;
$this->params['inscription_object_title'] = 'Моделі ПС';
$this->params['inscription_object_explanation'] = 'Список моделей ПС';

?>

<div class="plane-types-index">

    <div class="row">
        <div class="col-xs-12">
            <div class="portlet light bg-inverse block-border-top-3x-primary">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-list-alt"></i> <?= $this->params['inscription_object_explanation']?>
                    </div>
                    <div class="actions btn-set">
                        <?= Html::a('Додати нової моделі ПС', ['create'], ['class' => 'btn btn-primary']) ?>
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
                                    'template' => '{delete} {update} {view}',
                                    'header' => Html::a('<i class="fa fa-refresh"></i> Оновити', ['index'], ['class' => 'btn red']),
                                    'contentOptions' => ['class' => 'action-column'],
                                ],
                                [
                                    'attribute' => 'full_name_type',
                                    'content' => function($model) {
                                        return Html::encode($model->full_name_type);
                                    },
                                    'filter' => Html::activeTextInput($searchModel, 'full_name_type', [
                                        'class' => 'form-control form-filter input-sm',
                                        'placeholder' => $searchModel->getAttributeLabel('full_name_type'),
                                    ]),
                                ],
                                [
                                    'attribute' => 'marking',
                                    'content' => function($model) {
                                        return Html::encode($model->marking);
                                    },
                                    'filter' => Html::activeTextInput($searchModel, 'marking', [
                                        'class' => 'form-control form-filter input-sm',
                                        'placeholder' => $searchModel->getAttributeLabel('marking'),
                                    ]),
                                ],
                                [
                                    'attribute' => 'kind',
                                    'content' => function($model) {
                                        return $model->getKindName();
                                    },
                                    'filter' => Html::activeDropDownList($searchModel, 'kind', TypesPlanes::getKindList(), [
                                        'class' => 'form-control form-filter input-sm',
                                        'prompt' => '- Всі типи -'
                                    ]),
                                ],
                                [
                                    'attribute' => 'category_plane',
                                    'content' => function($model) {
                                        return $model->getCategoryName();
                                    },
                                    'filter' => Html::activeDropDownList($searchModel, 'category_plane', TypesPlanes::getCategoryList(), [
                                        'class' => 'form-control form-filter input-sm',
                                        'prompt' => '- Всі категорії -'
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