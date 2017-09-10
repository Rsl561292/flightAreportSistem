<?php

/* @var $this yii\web\View */
/* @var $model common\models\Platform */

$this->title = 'Редагування інформації';
$this->params['breadcrumbs'][] = ['label' => 'Посад. платформи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['inscription_object_title'] = 'Посад. платформи';
$this->params['inscription_object_explanation'] = 'Редагування інформації';
?>
<div class="platform-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>