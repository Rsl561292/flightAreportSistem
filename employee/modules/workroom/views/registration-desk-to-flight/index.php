<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;
use common\models\RegistrationDeskToFlight;
use common\models\Platform;
use common\models\Flights;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Реєстр. стійки в польотах';
$this->params['breadcrumbs'][] = $this->title;
$this->params['inscription_object_title'] = 'Реєстр. стійки в польотах';
$this->params['inscription_object_explanation'] = 'Список записів';

?>

<div class="registration-desk-to-flight-index">

    <div class="row">
        <div class="col-xs-12">
            <div class="portlet light bg-inverse block-border-top-3x-primary">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-list-alt"></i> <?= $this->params['inscription_object_explanation']?>
                    </div>
                    <div class="actions btn-set">
                        <?= Html::a('Додати запис', ['create'], ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>

                <div class="portlet-body">
                    <div class="table-responsive table-products">
                        <?php
                        Pjax::begin([
                            'id' => 'registration-desk-to-flight-grid',
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
                                    'visibleButtons' => [
                                        'delete' => function($model) {
                                            return $model->flight->status === Flights::STATUS_HAPPENED ? false : true;
                                        },
                                        'update' => function($model) {
                                            return $model->flight->status === Flights::STATUS_HAPPENED ? false : true;
                                        }
                                    ],
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
                                    'attribute' => 'registration_desk_id',
                                    'headerOptions' => ['width' => '110'],
                                    'content' => function($model) {
                                        return !empty($model->registrationDesk) ? Html::encode($model->registrationDesk->symbol) : '';
                                    },
                                    'filter' => Html::activeDropDownList($searchModel, 'registration_desk_id', Platform::getAllRecordListId(), [
                                        'class' => 'form-control form-filter input-sm',
                                        'prompt' => '- Всі стійки -'
                                    ]),
                                ],
                                [
                                    'attribute' => 'flight_id',
                                    'content' => function($model) {
                                        return !empty($model->flight) ? $model->flight->id.' : '.$model->flight->getDirectionName().', '.$model->flight->getStatusName().' в '.date('Y-m-d H:i', strtotime($model->flight->datetime_fact)) : '';
                                    },
                                    'filter' => Html::activeDropDownList($searchModel, 'flight_id', Flights::getAllRecordListIdRegistrationDesk(), [
                                        'class' => 'form-control form-filter input-sm',
                                        'prompt' => '- Всі польоти -'
                                    ]),
                                ],
                                [
                                    'attribute' => 'class',
                                    'headerOptions' => ['width' => '90'],
                                    'content' => function($model) {
                                        $class = 'label-default';

                                        switch ($model->class) {
                                            case RegistrationDeskToFlight::CLASS_BUSINESS:
                                                $class = 'label-success';
                                                break;
                                            case RegistrationDeskToFlight::CLASS_ECONOMIZE:
                                                $class = 'label-danger';
                                                break;
                                            case RegistrationDeskToFlight::CLASS_ECONOMIZE_AND_BUSINESS:
                                                $class = 'label-primary';
                                                break;
                                        }

                                        return Html::tag('span', $model->getClassName(), ['class' => 'label label-sm ' . $class]);
                                    },
                                    'filter' => Html::activeDropDownList($searchModel, 'class', RegistrationDeskToFlight::getClassList(), [
                                        'class' => 'form-control form-filter input-sm',
                                        'prompt' => '- Клас -'
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