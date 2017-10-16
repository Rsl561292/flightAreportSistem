<?php

/* @var $this yii\web\View */
/* @var $model common\models\Plane */

$this->title = 'Редагування інформації';
$this->params['breadcrumbs'][] = ['label' => 'Повітряні судна', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['inscription_object_title'] = 'Повітряні судна';
$this->params['inscription_object_explanation'] = 'Редагування інформації';
?>
<div class="plane-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>