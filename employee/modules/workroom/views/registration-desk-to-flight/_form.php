<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\RegistrationDeskToFlight;
use common\models\RegistrationDesk;
use common\models\Flights;

/* @var $this yii\web\View */
/* @var $model common\models\RegistrationDeskToFlight */
/* @var $form yii\widgets\ActiveForm */

$this->registerJs("
	$('#" . Html::getInputId($model, 'registration_desk_id') .
        ", #" . Html::getInputId($model, 'flight_id') . "').select2();
	$('#" . Html::getInputId($model, 'class') . "').select2({minimumResultsForSearch: -1});
", \yii\web\View::POS_READY);
?>

<div class="registration-desk-to-flight-form">
    <?php
    $form = ActiveForm::begin([
        'id' => 'registration-desk-to-flight-form',
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
                        <?php
                        $list = $model->isNewRecord ? RegistrationDesk::getActiveRecordListId() : RegistrationDesk::getAllRecordListId();
                        ?>
                        <div class="col-sm-7 col-lg-7">
                            <?= $form->field($model, 'registration_desk_id')->dropDownList($list, [
                                'class' => 'form-control',
                                'disabled' => $model->isNewRecord ? false : true,
                                'encode' => false,
                                'prompt' => '- Вибір -'
                            ]); ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-7 col-lg-7">
                            <?php
                                $list = $model->isNewRecord ? Flights::getActiveRecordListIdRegistrationDesk() : Flights::getAllRecordListIdRegistrationDesk();
                            ?>
                            <?= $form->field($model, 'flight_id')->dropDownList($list, [
                                'class' => 'form-control',
                                'disabled' => $model->isNewRecord ? false : true,
                                'encode' => false,
                                'prompt' => '- Вибір -'
                            ]); ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-5 col-lg-5">
                            <?= $form->field($model, 'class')->dropDownList(RegistrationDeskToFlight::getClassList(), [
                                'class' => 'form-control',
                                'encode' => false,
                                'prompt' => '- Вибір -'
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
    </div>
</div>

