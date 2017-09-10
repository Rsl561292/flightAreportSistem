<?php

/* @var $this yii\web\View */
/* @var $model common\models\Platform */

$this->title = 'Додати нову посад. платформу';
$this->params['breadcrumbs'][] = ['label' => 'Посад. платформи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['inscription_object_title'] = 'Посад. платформи';
$this->params['inscription_object_explanation'] = 'Додавання посад. платформи';
?>
<div class="platform-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>