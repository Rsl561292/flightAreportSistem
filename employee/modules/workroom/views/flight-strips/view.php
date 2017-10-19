<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\FlightStrips */


$this->title = 'Перегляд запису';
$this->params['breadcrumbs'][] = ['label' => 'Льотні смуги', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['inscription_object_title'] = 'Льотні смуги';
$this->params['inscription_object_explanation'] = 'Перегляд запису';
?>

<div class="flight-strips-view">

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
                                'name',
                                'marking',
                                [
                                    'attribute' => 'surface',
                                    'value' => function($model) {
                                        return $model->getSurfaceName();
                                    },
                                ],
                                [
                                    'attribute' => 'category',
                                    'value' => function($model) {
                                        return $model->getCategoryName();
                                    },
                                ],
                                [
                                    'attribute' => 'status',
                                    'value' => function($model) {
                                        return $model->getStatusName();
                                    },
                                ],
                                'length_NDR',
                                'bias_threshold',
                                'length_KSH',
                                'length_KZB',
                                'length_VZ',
                                'width',
                                'width_sidebar_safety',
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
