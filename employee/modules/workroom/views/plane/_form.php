<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use common\models\Plane;
use common\models\TypesPlanes;
use common\models\Carrier;

/* @var $this yii\web\View */
/* @var $model common\models\Plane */
/* @var $form yii\widgets\ActiveForm */

$this->registerJs("
	$('#" . Html::getInputId($model, 'status_location') . ", #" . Html::getInputId($model, 'status_preparation') . "').select2({minimumResultsForSearch: -1});
	$('#" . Html::getInputId($model, 'type_id') . ", #" . Html::getInputId($model, 'carrier_id') . "').select2();
", \yii\web\View::POS_READY);
?>

<div class="plane-form">
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
        'id' => 'plane-form',
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
                        <div class="col-sm-6 col-lg-6">
                            <?= $form->field($model, 'registration_code')->textInput([
                                'class' => 'form-control maxlength-handler',
                                'maxlength' => 20,
                            ]) ?>
                        </div>
                        <div class="col-sm-3 col-lg-3">
                            <?= $form->field($model, 'status_preparation')->dropDownList(Plane::getStatusPreparationList(), [
                                'class' => 'form-control',
                                'prompt' => '- Вибір -',
                            ]); ?>
                        </div>
                        <div class="col-sm-3 col-lg-3">
                            <?= $form->field($model, 'status_location')->dropDownList(Plane::getStatusLocationList(), [
                                'class' => 'form-control',
                                'prompt' => '- Вибір -',
                            ]); ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 col-lg-6">
                            <?= $form->field($model, 'type_id')->dropDownList(TypesPlanes::getAllRecordListId(), [
                                'class' => 'form-control',
                                'prompt' => '- Вибір -',
                            ]); ?>
                        </div>
                        <div class="col-sm-6 col-lg-6">
                            <?= $form->field($model, 'carrier_id')->dropDownList(Carrier::getAllRecordListId(), [
                                'class' => 'form-control',
                                'prompt' => '- Вибір -',
                            ]); ?>
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