<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use common\models\ScheduleBusyPlatform;
use common\models\Platform;
use common\models\Plane;
use common\models\Flights;

/* @var $this yii\web\View */
/* @var $model common\models\ScheduleBusyPlatform */
/* @var $form yii\widgets\ActiveForm */

$this->registerJs("
	$('#" . Html::getInputId($model, 'platform_id') .
        ", #" . Html::getInputId($model, 'plane_id') .
        ", #" . Html::getInputId($model, 'flight_id') . "').select2();
	$('#" . Html::getInputId($model, 'status') . "').select2({minimumResultsForSearch: -1});
", \yii\web\View::POS_READY);
?>

<div class="schedule-busy-platform-form">
    <?php
    Pjax::begin([
        'id' => 'schedule-busy-platform-grid',
        'timeout' => false,
        'enablePushState' => false,
        'clientOptions' => [
            'method' => 'get',
        ],
    ]);
    $form = ActiveForm::begin([
        'id' => 'schedule-busy-platform-form',
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
                        <div class="col-sm-4 col-lg-4">
                            <?= $form->field($model, 'platform_id')->dropDownList(Platform::getActiveRecordListId(), [
                                'class' => 'form-control',
                                'encode' => false,
                                'prompt' => '- Вибір -'
                            ]); ?>
                        </div>
                        <div class="col-sm-4 col-lg-4">
                            <?= $form->field($model, 'plane_id')->dropDownList(Plane::getActiveRecordListId(), [
                                'class' => 'form-control',
                                'encode' => false,
                                'prompt' => '- Вибір -'
                            ]); ?>
                        </div>
                        <div class="col-sm-4 col-lg-4">
                            <?= $form->field($model, 'flight_id')->dropDownList(Flights::getActiveRecordListIdCompiledData(), [
                                'class' => 'form-control',
                                'encode' => false,
                                'prompt' => '- Вибір -'
                            ]); ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 col-lg-6">
                            <?= $form->field($model, 'begin_busy_plan')->widget(DateTimePicker::classname(), [
                                'class' => 'form-control maxlength-handler',
                                'options' => ['placeholder' => 'Введіть дату та час ...'],
                                'pluginOptions' => [
                                    'autoclose' => true
                                ]
                            ]) ?>
                        </div>
                        <div class="col-sm-6 col-lg-6">
                            <?= $form->field($model, 'end_busy_plan')->widget(DateTimePicker::classname(), [
                                'class' => 'form-control maxlength-handler',
                                'options' => ['placeholder' => 'Введіть дату та час ...'],
                                'pluginOptions' => [
                                    'autoclose' => true
                                ]
                            ]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-lg-6">
                            <?= $form->field($model, 'begin_busy_fact')->widget(DateTimePicker::classname(), [
                                'class' => 'form-control maxlength-handler',
                                'options' => ['placeholder' => ''],
                                'disabled' => true,
                                'pluginOptions' => [
                                    'autoclose' => true,
                                ]
                            ]) ?>
                        </div>
                        <div class="col-sm-6 col-lg-6">
                            <?= $form->field($model, 'end_busy_fact')->widget(DateTimePicker::classname(), [
                                'class' => 'form-control maxlength-handler',
                                'options' => ['placeholder' => ''],
                                'disabled' => true,
                                'pluginOptions' => [
                                    'autoclose' => true,
                                ]
                            ]) ?>
                    </div>

                    <div class="row">
                        <div class="col-sm-7 col-lg-7">
                            <?php
                                $listStatus = ScheduleBusyPlatform::getStatusList();

                                if ($model->isNewRecord) {
                                    unset($listStatus[ScheduleBusyPlatform::STATUS_USED], $listStatus[ScheduleBusyPlatform::STATUS_COMPLETED]);
                                } else {

                                    if ($model->status == ScheduleBusyPlatform::STATUS_SCHEDULED) {
                                        unset($listStatus[ScheduleBusyPlatform::STATUS_COMPLETED]);
                                    }
                                }
                            ?>

                            <?= $form->field($model, 'status')->dropDownList($listStatus, [
                                'id' => 'schedulebusyplatform-status',
                                'class' => 'form-control',
                                'encode' => false,
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

<script type="text/javascript">
    var fieldBeginBusyFact = $('#<?= Html::getInputId($model, 'begin_busy_fact') ?>');
    var fieldEndBusyFact = $('#<?= Html::getInputId($model, "end_busy_fact") ?>');

    $(document).on('change', '#schedulebusyplatform-status', function() {
        var value = $(this).val();
        var dateTime = new Date();

        console.log('date='+value);

        switch(value) {
            case '<?= ScheduleBusyPlatform::STATUS_SCHEDULED ?>':
                fieldBeginBusyFact.val('');
                fieldEndBusyFact.val('');
                break;
            case '<?= ScheduleBusyPlatform::STATUS_USED ?>':
                alert('Date='+dateTime);
                fieldBeginBusyFact.val(dateTime);
                fieldEndBusyFact.val('');
                break;
            case '<?= ScheduleBusyPlatform::STATUS_COMPLETED ?>':
                fieldBeginBusyFact.val('');
                fieldEndBusyFact.val('');
                break;

            default:
        }
    });

</script>
