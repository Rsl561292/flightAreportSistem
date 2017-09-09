<?php

/* @var $this yii\web\View */
/* @var $model common\models\RegistrationDesk */

$this->title = 'Редагування інформації';
$this->params['breadcrumbs'][] = ['label' => 'Реєстр. стійки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['inscription_object_title'] = 'Реєстр. стійки';
$this->params['inscription_object_explanation'] = 'Редагування інформації';
?>
<div class="registration-desk-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
