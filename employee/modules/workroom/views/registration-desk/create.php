<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\RegistrationDesk */

$this->title = 'Create Registration Desk';
$this->params['breadcrumbs'][] = ['label' => 'Registration Desks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="registration-desk-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
