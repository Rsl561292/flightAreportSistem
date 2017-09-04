<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Terminals */

$this->title = 'Редагування інформації';
$this->params['breadcrumbs'][] = ['label' => 'Термінали', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['inscription_object_title'] = 'Термінали';
$this->params['inscription_object_explanation'] = 'Редагування інформації';
?>
<div class="terminals-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
