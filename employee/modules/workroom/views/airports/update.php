<?php

/* @var $this yii\web\View */
/* @var $model common\models\Airports */

$this->title = 'Редагування інформації';
$this->params['breadcrumbs'][] = ['label' => 'Аеропорти', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['inscription_object_title'] = 'Аеропорти';
$this->params['inscription_object_explanation'] = 'Редагування інформації';
?>
<div class="airports-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>