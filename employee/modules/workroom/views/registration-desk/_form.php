<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use kartik\select2\Select2;
use common\models\Terminals;
use common\models\RegistrationDesk;

/* @var $this yii\web\View */
/* @var $model common\models\RegistrationDesk */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="registration-desk-form">
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
            'id' => 'registration-desk-form',
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
                            <div class="col-sm-2 col-lg-2">
                                <?= $form->field($model, 'symbol')->textInput([
                                    'class' => 'form-control maxlength-handler',
                                    'maxlength' => 5,
                                ]) ?>
                            </div>
                            <div class="col-sm-6 col-lg-6">
                                <div class="box-margin-left-10px">
                                    <?= $form->field($model, 'terminal_id')->widget(Select2::className(),[
                                        'class' => 'form-control',
                                        'data' => Terminals::getTerminalsListAll(),
                                        'options' => [
                                            'placeholder' => 'Виберіть термінал ...',
                                        ],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ]); ?>
                                </div>
                            </div>
                            <div class="col-sm-4 col-lg-4">
                                <div class="box-margin-left-10px">
                                    <div class="box-margin-left-10px">
                                        <?= $form->field($model, 'status')->widget(Select2::className(),[
                                            'class' => 'form-control',
                                            'hideSearch' => true,
                                            'data' => RegistrationDesk::getStatusList(),
                                            'options' => [
                                                'placeholder' => 'Виберіть статус ...',
                                            ],
                                            'pluginOptions' => [
                                                'allowClear' => true
                                            ],
                                        ]); ?>
                                </div>
                            </div>
                        </div>

                        <?= $form->field($model, 'description')->widget(CKEditor::className(),[
                            'options' => [
                                'placeholder' => 'Опис об\'єкта та інша інформація про нього ...',
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
