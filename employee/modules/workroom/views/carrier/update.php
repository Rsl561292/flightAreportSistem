<?php

/* @var $this yii\web\View */
/* @var $model common\models\GisRegions */

$this->title = 'Редагування інформації';
$this->params['breadcrumbs'][] = ['label' => 'Авіаперевізники', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['inscription_object_title'] = 'Авіаперевізники';
$this->params['inscription_object_explanation'] = 'Редагування інформації';
?>
<div class="carrier-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>