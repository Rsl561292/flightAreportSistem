<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use common\models\Flights;
use common\models\Plane;
use common\models\FlightStrips;
use common\models\Airports;

/* @var $this yii\web\View */
/* @var $model common\models\Flights */
/* @var $form yii\widgets\ActiveForm */

$this->registerJs("
	$('#" . Html::getInputId($model, 'plane_id') .
        ", #" . Html::getInputId($model, 'strip_id') .
        ", #" . Html::getInputId($model, 'airport_id') . "').select2();
	$('#" . Html::getInputId($model, 'type') .
        ", #" . Html::getInputId($model, 'direction') .
        ", #" . Html::getInputId($model, 'status') .
        ", #" . Html::getInputId($model, 'visible') . "').select2({minimumResultsForSearch: -1});
", \yii\web\View::POS_READY);
?>

<div class="flights-form">
    <?php
    Pjax::begin([
        'id' => 'flights-grid',
        'timeout' => false,
        'enablePushState' => false,
        'clientOptions' => [
            'method' => 'get',
        ],
    ]);
    $form = ActiveForm::begin([
        'id' => 'flights-form',
        'enableClientValidation' => false,
        'enableAjaxValidation' => false,
        'validateOnSubmit' => true,
        'options' => [
            'role' => 'form',
            'class' => 'my-css-form form-horizontal form-row-seperated',
        ],
        'fieldConfig' => [
            'template' => '{label}{input}{hint}',
            'hintOptions' => ['class' => 'help-block'],
        ],
    ]);
    ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="portlet light bg-inverse block-border-top-3x-primary">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-pencil-square-o"></i> <?= Html::encode($this->params['inscription_object_explanation'])?>
                    </div>
                    <div class="actions btn-set">
                        <?= Html::a('<i class="fa fa-angle-left"></i> Назад', ['index'], ['class' => 'btn default']) ?>
                        <?= Html::a('<i class="fa fa-reply"></i> Скинути', $model->isNewRecord ? ['create'] : ['update', 'id' => $model->id], ['class' => 'btn default']) ?>
                        <?= Html::submitButton('<i class="fa fa-check"></i> Зберегти', ['class' => 'btn green']) ?>
                        <?= Html::submitButton('<i class="fa fa-check-circle"></i> Зберегти та продовжити', ['class' => 'btn green', 'name' => 'continueEdit']) ?>
                    </div>
                </div>

                <div class="box-body">
                    <?php if ($model->hasErrors()) : ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4><i class="icon fa fa-ban"></i> Помилка!</h4>
                            <?= $form->errorSummary($model);?>
                        </div>
                    <?php endif;?>

                    <div class="row">
                        <div class="col-sm-3 col-lg-3">
                            <?= $form->field($model, 'type')->dropDownList(Flights::getTypeList(), [
                                'class' => 'form-control',
                                'encode' => false,
                                'prompt' => '- Вибір -'
                            ]); ?>
                        </div>
                        <div class="col-sm-3 col-lg-3">
                            <?= $form->field($model, 'direction')->dropDownList(Flights::getDirectionList(), [
                                'class' => 'form-control',
                                'encode' => false,
                                'prompt' => '- Вибір -'
                            ]); ?>
                        </div>
                        <div class="col-sm-3 col-lg-3">
                            <?= $form->field($model, 'status')->dropDownList(Flights::getStatusList(), [
                                'class' => 'form-control',
                                'encode' => false,
                                'prompt' => '- Вибір -'
                            ]); ?>
                        </div>
                        <div class="col-sm-3 col-lg-3">
                            <?= $form->field($model, 'visible')->dropDownList(Flights::getVisibleList(), [
                                'class' => 'form-control',
                                'encode' => false,
                                'prompt' => '- Вибір -'
                            ]); ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 col-lg-6">
                            <?= $form->field($model, 'datetime_plane')->widget(DateTimePicker::classname(), [
                                'class' => 'form-control maxlength-handler',
                                'options' => ['placeholder' => 'Введіть дату та час ...'],
                                'pluginOptions' => [
                                    'autoclose' => true
                                ]
                            ]) ?>
                        </div>
                        <div class="col-sm-6 col-lg-6">
                            <?= $form->field($model, 'datetime_fact')->widget(DateTimePicker::classname(), [
                                'class' => 'form-control maxlength-handler',
                                'options' => ['placeholder' => 'Введіть дату та час ...'],
                                'pluginOptions' => [
                                    'autoclose' => true
                                ]
                            ]) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4 col-lg-4">
                            <?= $form->field($model, 'plane_id')->dropDownList(Plane::getActiveRecordListId(), [
                                'class' => 'form-control',
                                'encode' => false,
                                'prompt' => '- Вибір -'
                            ]); ?>
                        </div>
                        <div class="col-sm-4 col-lg-4">
                            <?= $form->field($model, 'strip_id')->dropDownList(FlightStrips::getActiveRecordListId(), [
                                'class' => 'form-control',
                                'encode' => false,
                                'prompt' => '- Вибір -'
                            ]); ?>
                        </div>
                        <div class="col-sm-4 col-lg-4">
                            <?= $form->field($model, 'airport_id')->dropDownList(Airports::getActiveRecordListId(), [
                                'class' => 'form-control',
                                'encode' => false,
                                'prompt' => '- Вибір -'
                            ]); ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 col-lg-6">
                            <?= $form->field($model, 'begin_registration_plan')->widget(DateTimePicker::classname(), [
                                'class' => 'form-control maxlength-handler',
                                'options' => ['placeholder' => 'Введіть дату та час ...'],
                                'pluginOptions' => [
                                    'autoclose' => true
                                ]
                            ]) ?>
                        </div>
                        <div class="col-sm-6 col-lg-6">
                            <?= $form->field($model, 'end_registration_plan')->widget(DateTimePicker::classname(), [
                                'class' => 'form-control maxlength-handler',
                                'options' => ['placeholder' => 'Введіть дату та час ...'],
                                'pluginOptions' => [
                                    'autoclose' => true
                                ]
                            ]) ?>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 col-lg-6">
                            <?= $form->field($model, 'begin_landing_plan')->widget(DateTimePicker::classname(), [
                                'class' => 'form-control maxlength-handler',
                                'options' => ['placeholder' => 'Введіть дату та час ...'],
                                'pluginOptions' => [
                                    'autoclose' => true
                                ]
                            ]) ?>
                        </div>
                        <div class="col-sm-6 col-lg-6">
                            <?= $form->field($model, 'end_landing_plan')->widget(DateTimePicker::classname(), [
                                'class' => 'form-control maxlength-handler',
                                'options' => ['placeholder' => 'Введіть дату та час ...'],
                                'pluginOptions' => [
                                    'autoclose' => true
                                ]
                            ]) ?>
                        </div>
                    </div>

                    <div class="form-actions right">
                        <div class="row">
                            <div class="col-md-12">
                                <?= Html::a('Скасувати', ['index'], ['class' => 'btn default']) ?>
                                <?= Html::submitButton('Зберегти', ['class' => 'btn green']) ?>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <!-- /.col -->
        </div>
        <?php ActiveForm::end(); ?>
        <?php Pjax::end(); ?>
    </div>
</div>