<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\grid\GridView;
use common\models\GisCountry;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Країни';
$this->params['breadcrumbs'][] = $this->title;
$this->params['inscription_object_title'] = 'Країни';
$this->params['inscription_object_explanation'] = 'Список країн';

$this->registerJs("
	$(document).on('change', '.status-switcher', function() {
		var select = $(this);

		$.post('" . Url::toRoute('update-status') . "', {id: $(this).closest('tr').data('key'), status: $(this).val()}, function(data) {
			if (data.response === true) {
				$.pjax.reload({container: '#country-grid'});
			}
			else {
				alert('Internal country error. Please try again.');
			}
		});
	});
", \yii\web\View::POS_READY);
?>

<div class="country-index">

    <div class="row">
        <div class="col-xs-12">
            <div class="portlet light bg-inverse block-border-top-3x-primary">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-list-alt"></i> <?= $this->params['inscription_object_explanation']?>
                    </div>
                </div>

                <div class="portlet-body">
                    <div class="table-responsive table-products">
                        <?php
                        Pjax::begin([
                            'id' => 'country-grid',
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
                                    'attribute' => 'code',
                                    'label' => 'Код',
                                    'content' => function($model) {
                                        return $model->code;
                                    },
                                    'filter' => Html::activeTextInput($searchModel, 'code', [
                                        'class' => 'form-control form-filter input-sm',
                                        'placeholder' => $searchModel->getAttributeLabel('code'),
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
                                    'attribute' => 'status',
                                    'format' => 'raw',
                                    'content' => function($model) {
                                        return Html::dropDownList("status-{$model->id}", $model->status, GisCountry::getStatusList(), [
                                            'class' => 'status-switcher form-control input-sm',
                                        ]);
                                    },
                                    'filter' => Html::activeDropDownList($searchModel, 'status', GisCountry::getStatusList(), [
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
