<?php

/* @var $this yii\web\View */
/* @var $model common\models\FlightStrips */

$this->title = 'Додати нову льотну смугу';
$this->params['breadcrumbs'][] = ['label' => 'Льотні смуги', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['inscription_object_title'] = 'Льотні смуги';
$this->params['inscription_object_explanation'] = 'Додавання льотної смуги';
?>
<div class="flight-strips-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>