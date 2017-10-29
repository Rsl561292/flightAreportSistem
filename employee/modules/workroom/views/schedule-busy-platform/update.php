<?php

/* @var $this yii\web\View */
/* @var $model common\models\Flights */

$this->title = 'Редагування інформації';
$this->params['breadcrumbs'][] = ['label' => 'Польоти', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['inscription_object_title'] = 'Польоти';
$this->params['inscription_object_explanation'] = 'Редагування інформації';
?>
<div class="flights-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>