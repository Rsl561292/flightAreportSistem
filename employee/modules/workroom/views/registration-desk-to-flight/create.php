<?php

/* @var $this yii\web\View */
/* @var $model common\models\RegistrationDeskToFlight */

$this->title = 'Додавання запису';
$this->params['breadcrumbs'][] = ['label' => 'Реєстр. стійки в польотах', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['inscription_object_title'] = 'Реєстр. стійки в польотах';
$this->params['inscription_object_explanation'] = 'Додавання запису';
?>
<div class="registration-desk-to-flight-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>