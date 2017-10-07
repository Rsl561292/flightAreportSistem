<?php

/* @var $this yii\web\View */
/* @var $model common\models\GisRegions */

$this->title = 'Редагування інформації';
$this->params['breadcrumbs'][] = ['label' => 'Регіони країн', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['inscription_object_title'] = 'Регіони країн';
$this->params['inscription_object_explanation'] = 'Редагування інформації';
?>
<div class="region-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>