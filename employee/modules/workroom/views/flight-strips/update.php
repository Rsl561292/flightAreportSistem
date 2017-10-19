<?php

/* @var $this yii\web\View */
/* @var $model common\models\FlightStrips */

$this->title = 'Редагування інформації';
$this->params['breadcrumbs'][] = ['label' => 'Льотні смуги', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['inscription_object_title'] = 'Льотні смуги';
$this->params['inscription_object_explanation'] = 'Редагування інформації';
?>
<div class="flight-strips-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>