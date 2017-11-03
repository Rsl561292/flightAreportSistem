<?php

/* @var $this yii\web\View */
/* @var $model common\models\ScheduleBusyPlatform */

$this->title = 'Редагування';
$this->params['breadcrumbs'][] = ['label' => 'Графіки зайнятості перону', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['inscription_object_title'] = 'Графіки зайнятості перону';
$this->params['inscription_object_explanation'] = 'Редагування';
?>
<div class="schedule-busy-platform-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>