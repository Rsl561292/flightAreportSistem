<?php

/* @var $this yii\web\View */
/* @var $model common\models\Airports */

$this->title = 'Додати новий аеропорт';
$this->params['breadcrumbs'][] = ['label' => 'Аеропорти', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['inscription_object_title'] = 'Аеропорти';
$this->params['inscription_object_explanation'] = 'Додавання аеропорту';
?>
<div class="airports-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>