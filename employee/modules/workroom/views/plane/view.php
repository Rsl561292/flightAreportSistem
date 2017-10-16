<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Plane */


$this->title = 'Перегляд запису';
$this->params['breadcrumbs'][] = ['label' => 'Повітряні судна', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['inscription_object_title'] = 'Повітряні судна';
$this->params['inscription_object_explanation'] = 'Перегляд запису';
?>

<div class="plane-view">

    <div class="row">
        <div class="col-xs-12">
            <div class="portlet light bg-inverse block-border-top-3x-primary">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-list-alt"></i> <?= $this->params['inscription_object_explanation']?>
                    </div>
                    <div class="actions btn-set">
                        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Ви впевнені, що хочете видалити цей запис?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </div>
                </div>

                <div class="portlet-body">
                    <div class="table-responsive table-products">
                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                'registration_code',
                                [
                                    'attribute' => 'type_id',
                                    'value' => function($model) {
                                        return !empty($model->type) ? Html::encode($model->type->full_name_type) : '';
                                    },
                                ],
                                [
                                    'attribute' => 'carrier_id',
                                    'value' => function($model) {
                                        return !empty($model->carrier) ? Html::encode($model->carrier->name) : '';
                                    },
                                ],
                                [
                                    'attribute' => 'status_preparation',
                                    'value' => function($model) {
                                        return $model->getStatusPreparationName();
                                    },
                                ],
                                [
                                    'attribute' => 'status_location',
                                    'value' => function($model) {
                                        return $model->getStatusLocationName();
                                    },
                                ],
                            ],
                        ]) ?>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <!-- /.col -->
    </div>
</div>
