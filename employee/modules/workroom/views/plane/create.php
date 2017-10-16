<?php

/* @var $this yii\web\View */
/* @var $model common\models\Plane */

$this->title = 'Додавання нового повітряного судна';
$this->params['breadcrumbs'][] = ['label' => 'Повітряні судна', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['inscription_object_title'] = 'Повітряні судна';
$this->params['inscription_object_explanation'] = 'Додавання повітряного судна';
?>
<div class="plane-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>