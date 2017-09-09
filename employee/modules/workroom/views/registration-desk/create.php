<?php

/* @var $this yii\web\View */
/* @var $model common\models\RegistrationDesk */

$this->title = 'Додати реєстр. стійку';
$this->params['breadcrumbs'][] = ['label' => 'Реєстр. стійки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['inscription_object_title'] = 'Реєстр. стійки';
$this->params['inscription_object_explanation'] = 'Додавання реєстр. стійки';
?>
<div class="registration-desk-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

