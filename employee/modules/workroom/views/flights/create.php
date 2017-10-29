<?php

/* @var $this yii\web\View */
/* @var $model common\models\Flights */

$this->title = 'Додати новий політ';
$this->params['breadcrumbs'][] = ['label' => 'Польоти', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['inscription_object_title'] = 'Польоти';
$this->params['inscription_object_explanation'] = 'Додавання нового польоту';
?>
<div class="flights-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>