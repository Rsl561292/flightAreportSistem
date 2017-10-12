<?php

/* @var $this yii\web\View */
/* @var $model common\models\GisRegions */

$this->title = 'Додати нового авіаперевізника';
$this->params['breadcrumbs'][] = ['label' => 'Авіаперевізники', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['inscription_object_title'] = 'Авіаперевізники';
$this->params['inscription_object_explanation'] = 'Додавання авіаперевізника';
?>
<div class="carrier-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>