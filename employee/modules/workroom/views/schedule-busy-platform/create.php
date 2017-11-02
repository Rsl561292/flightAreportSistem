<?php

/* @var $this yii\web\View */
/* @var $model common\models\ScheduleBusyPlatform */

$this->title = 'Додавання запису';
$this->params['breadcrumbs'][] = ['label' => 'Графіки зайнятості перону', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['inscription_object_title'] = 'Графіки зайнятості перону';
$this->params['inscription_object_explanation'] = 'Додавання запису';
?>
<div class="schedule-busy-platform-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>