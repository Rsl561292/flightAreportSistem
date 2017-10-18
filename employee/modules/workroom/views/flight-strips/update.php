<?php

/* @var $this yii\web\View */
/* @var $model common\models\TypesPlanes */

$this->title = 'Редагування інформації';
$this->params['breadcrumbs'][] = ['label' => 'Моделі ПС', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['inscription_object_title'] = 'Моделі ПС';
$this->params['inscription_object_explanation'] = 'Редагування інформації';
?>
<div class="plane-types-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>