<?php

/* @var $this yii\web\View */
/* @var $model common\models\TypesPlanes */

$this->title = 'Додати нову модель';
$this->params['breadcrumbs'][] = ['label' => 'Моделі ПС', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['inscription_object_title'] = 'Моделі ПС';
$this->params['inscription_object_explanation'] = 'Додавання моделі ПС';
?>
<div class="plane-types-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>