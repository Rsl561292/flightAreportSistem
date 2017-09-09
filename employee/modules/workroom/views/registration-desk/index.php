<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;
use common\models\Terminals;
use common\models\RegistrationDesk;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Реєстр. стійки';
$this->params['breadcrumbs'][] = $this->title;
$this->params['inscription_object_title'] = 'Реєстр. стійки';
$this->params['inscription_object_explanation'] = 'Список реєстр. стійок';
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
                        <?= Html::a('Додати нову реєстр. стійку', ['create'], ['class' => 'btn btn-primary']) ?>
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
                                    'attribute' => 'symbol',
                                    'headerOptions' => ['width' => '15%'],
                                    'content' => function($model) {
                                        return $model->symbol;
                                    },
                                    'filter' => Html::activeTextInput($searchModel, 'symbol', [
                                        'class' => 'form-control form-filter input-sm',
                                        'placeholder' => $searchModel->getAttributeLabel('symbol'),
                                    ]),

                                ],
                                [
                                    'attribute' => 'terminal_id',
                                    'headerOptions' => ['width' => '55%'],
                                    'content' => function($model) {
                                        return $model->terminal_id !== null? Html::encode($model->terminals->name) : '';
                                    },
                                    'filter' => Html::activeDropDownList($searchModel, 'terminal_id', Terminals::getTerminalsListAll(), [
                                        'class' => 'form-control form-filter input-sm',
                                        'prompt' => '- Термінал -'
                                    ]),

                                ],
                                [
                                    'attribute' => 'status',
                                    'headerOptions' => ['width' => '20%'],
                                    'content' => function($model) {
                                        $class = 'label-primary';

                                        switch ($model->status) {
                                            case RegistrationDesk::STATUS_WORKING_AND_OPEN:
                                                $class = 'label-success';
                                                break;
                                            case RegistrationDesk::STATUS_NOT_WORKING:
                                                $class = 'label-danger';
                                                break;
                                            case RegistrationDesk::STATUS_WORKING_AND_CLOSE:
                                                $class = 'label-warning';
                                                break;
                                        }

                                        return Html::tag('span', $model->getStatusName(), ['class' => 'label label-sm ' . $class]);
                                    },
                                    'filter' => Html::activeDropDownList($searchModel, 'status', RegistrationDesk::getStatusList(), [
                                        'class' => 'form-control form-filter input-sm',
                                        'prompt' => '- Статус -'
                                    ]),
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