<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use common\models\TypesPlanes;

/* @var $this yii\web\View */
/* @var $model common\models\TypesPlanes */
/* @var $form yii\widgets\ActiveForm */

$this->registerJs("
	$('#" . Html::getInputId($model, 'kind') . ", #" . Html::getInputId($model, 'category_plane') . "').select2({minimumResultsForSearch: -1});
", \yii\web\View::POS_READY);
?>

<div class="carrier-form">
    <?php
    Pjax::begin([
        'id' => 'plane-types-grid',
        'timeout' => false,
        'enablePushState' => false,
        'clientOptions' => [
            'method' => 'get',
        ],
    ]);
    $form = ActiveForm::begin([
        'id' => 'plane-types-form',
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
                        <div class="col-sm-8 col-lg-8">
                            <?= $form->field($model, 'full_name_type')->textInput([
                                'class' => 'form-control maxlength-handler',
                                'maxlength' => 255,
                            ]) ?>
                        </div>
                        <div class="col-sm-4 col-lg-4">
                            <div class="box-margin-left-5px">
                                <?= $form->field($model, 'marking')->textInput([
                                    'class' => 'form-control maxlength-handler',
                                    'maxlength' => 30,
                                ]) ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 col-lg-6">
                            <?= $form->field($model, 'kind')->dropDownList(TypesPlanes::getKindList(), [
                                'class' => 'form-control',
                                'prompt' => '- Вибір -',
                            ]); ?>
                        </div>
                        <div class="col-sm-6 col-lg-6">
                            <div class="box-margin-left-5px">
                                <?= $form->field($model, 'category_plane')->dropDownList(TypesPlanes::getCategoryList(), [
                                    'class' => 'form-control',
                                    'prompt' => '- Вибір -',
                                ]); ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4 col-lg-4">
                            <?= $form->field($model, 'length')->input('number', [
                                'class' => 'form-control maxlength-handler',
                            ]) ?>
                        </div>
                        <div class="col-sm-4 col-lg-4">
                            <?= $form->field($model, 'wingspan')->input('number', [
                                'class' => 'form-control maxlength-handler',
                            ]) ?>
                        </div>
                        <div class="col-sm-4 col-lg-4">
                            <?= $form->field($model, 'need_length_trip')->input('number', [
                                'class' => 'form-control maxlength-handler',
                            ]) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4 col-lg-4">
                            <?= $form->field($model, 'weight_empty_plane')->input('number', [
                                'class' => 'form-control maxlength-handler',
                            ]) ?>
                        </div>
                        <div class="col-sm-4 col-lg-4">
                            <?= $form->field($model, 'max_take_off_mass')->input('number', [
                                'class' => 'form-control maxlength-handler',
                            ]) ?>
                        </div>
                        <div class="col-sm-4 col-lg-4">
                            <?= $form->field($model, 'max_load')->input('number', [
                                'class' => 'form-control maxlength-handler',
                            ])->label('Допустиме навантаження') ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4 col-lg-4">
                            <?= $form->field($model, 'max_stock_fuel')->input('number', [
                                'class' => 'form-control maxlength-handler',
                            ]) ?>
                        </div>
                        <div class="col-sm-4 col-lg-4">
                            <?= $form->field($model, 'fuel_costs_empty')->input('number', [
                                'class' => 'form-control maxlength-handler',
                            ]) ?>
                        </div>
                        <div class="col-sm-4 col-lg-4">
                            <?= $form->field($model, 'fuel_costs_unit_weight')->input('number', [
                                'class' => 'form-control maxlength-handler',
                            ]) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-3 col-lg-3">
                            <?= $form->field($model, 'max_speed')->input('number', [
                                'class' => 'form-control maxlength-handler',
                            ]) ?>
                        </div>
                        <div class="col-sm-3 col-lg-3">
                            <?= $form->field($model, 'cruising_speed')->input('number', [
                                'class' => 'form-control maxlength-handler',
                            ]) ?>
                        </div>
                        <div class="col-sm-3 col-lg-3">
                            <?= $form->field($model, 'max_height')->input('number', [
                                'class' => 'form-control maxlength-handler',
                            ]) ?>
                        </div>
                        <div class="col-sm-3 col-lg-3">
                            <?= $form->field($model, 'cruising_height')->input('number', [
                                'class' => 'form-control maxlength-handler',
                            ]) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 col-lg-6">
                            <?= $form->field($model, 'max_distance_empty')->input('number', [
                                'class' => 'form-control maxlength-handler',
                            ]) ?>
                        </div>
                        <div class="col-sm-6 col-lg-6">
                            <?= $form->field($model, 'distance_one_load')->input('number', [
                                'class' => 'form-control maxlength-handler',
                            ]) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-3 col-lg-3">
                            <?= $form->field($model, 'height_fuselage')->input('number', [
                                'class' => 'form-control maxlength-handler',
                            ]) ?>
                        </div>
                        <div class="col-sm-3 col-lg-3">
                            <?= $form->field($model, 'width_fuselage')->input('number', [
                                'class' => 'form-control maxlength-handler',
                            ]) ?>
                        </div>
                        <div class="col-sm-3 col-lg-3">
                            <?= $form->field($model, 'height_salon')->input('number', [
                                'class' => 'form-control maxlength-handler',
                            ]) ?>
                        </div>
                        <div class="col-sm-3 col-lg-3">
                            <?= $form->field($model, 'width_salon')->input('number', [
                                'class' => 'form-control maxlength-handler',
                            ]) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4 col-lg-4">
                            <?= $form->field($model, 'max_number_seats')->input('number', [
                                'class' => 'form-control maxlength-handler',
                            ]) ?>
                        </div>
                        <div class="col-sm-4 col-lg-4">
                            <?= $form->field($model, 'seats_business_class')->input('number', [
                                'class' => 'form-control maxlength-handler',
                            ]) ?>
                        </div>
                        <div class="col-sm-4 col-lg-4">
                            <?= $form->field($model, 'count_crew')->input('number', [
                                'class' => 'form-control maxlength-handler',
                            ]) ?>
                        </div>
                    </div>

                    <div class="row">
                        <?= $form->field($model, 'comment')->widget(CKEditor::className(),[
                            'options' => [
                                'rows' => 10
                            ]
                        ]) ?>
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