<?php

/* @var $this yii\web\View */
/* @var $model common\models\GisRegions */

$this->title = 'Додати новий регіон/штат країни';
$this->params['breadcrumbs'][] = ['label' => 'Регіони країн', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['inscription_object_title'] = 'Регіони країн';
$this->params['inscription_object_explanation'] = 'Додавання регіону/штату країни';
?>
<div class="region-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>