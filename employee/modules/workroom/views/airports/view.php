<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Carrier */


$this->title = 'Перегляд запису';
$this->params['breadcrumbs'][] = ['label' => 'Авіаперевізники', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['inscription_object_title'] = 'Авіаперевізники';
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
                                'identification_code',
                                'name',
                                [
                                    'attribute' => 'country_id',
                                    'value' => function($model) {
                                        return !empty($model->country) ? Html::encode($model->country->name) : '';
                                    },
                                ],
                                [
                                    'attribute' => 'region_id',
                                    'value' => function($model) {
                                        return !empty($model->region) ? Html::encode($model->region->name) : '';
                                    },
                                ],
                                'city',
                                'other_address',
                                'phone',
                                'email',
                                [
                                    'attribute' => 'status',
                                    'value' => function($model) {
                                        return $model->getStatusName();
                                    },
                                ],
                                'short_description',
                                'description',
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
