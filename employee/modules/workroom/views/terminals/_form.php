<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use common\models\Terminals;

/* @var $this yii\web\View */
/* @var $model common\models\Terminals */
/* @var $form yii\widgets\ActiveForm */

$this->registerJs("
	$('#" . Html::getInputId($model, 'status') . "').select2({minimumResultsForSearch: -1});
", \yii\web\View::POS_READY);
?>

<div class="terminals-form">
    <?php
    Pjax::begin([
        'id' => 'terminal-grid',
        'timeout' => false,
        'enablePushState' => false,
        'clientOptions' => [
            'method' => 'get',
        ],
    ]);
        $form = ActiveForm::begin([
            'id' => 'terminal-form',
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
                                        <?= $form->field($model, 'symbol')->textInput([
                                            'class' => 'form-control maxlength-handler',
                                            'maxlength' => 1,
                                        ]) ?>
                                    </div>
                                    <div class="col-sm-9 col-lg-9">
                                        <div class="box-margin-left-10px">
                                            <?= $form->field($model, 'name')->textInput([
                                                'class' => 'form-control maxlength-handler',
                                                'maxlength' => 255,
                                            ]) ?>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3 col-lg-3">
                                        <?= $form->field($model, 'area')->textInput() ?>
                                    </div>
                                    <div class="col-sm-4 col-lg-4">
                                        <div class="box-margin-left-10px">
                                            <?= $form->field($model, 'year_built')->widget(DatePicker::className(),[
                                                'name' => 'check_issue_date',
                                                'options' => [
                                                    'placeholder' => 'Виберіть дату побудови ...'
                                                ],
                                                'pluginOptions' => [
                                                    'format' => 'yyyy-mm-dd',
                                                    'todayHighlight' => true
                                                ]
                                            ]) ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-5 col-lg-5">
                                        <div class="box-margin-left-10px">
                                            <?= $form->field($model, 'status')->dropDownList(Terminals::getStatusList(), [
                                                'class' => 'form-control',
                                                'prompt' => '- Вибір -',
                                            ]); ?>
                                        </div>
                                    </div>
                                </div>

                                <?= $form->field($model, 'description')->widget(CKEditor::className(),[
                                    'options' => [
                                        'rows' => 6
                                    ]
                                ]) ?>

                            <div class="form-actions right">
                                <div class="row">
                                    <div class="col-md-12">
                                        <?= Html::a('Скасувати', ['index'], ['class' => 'btn default']) ?>
                                        <?= Html::submitButton('Зберегти', ['class' => 'btn green']) ?>
                                    </div>
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
