<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Terminals */

$this->title = 'Додати термінал';
$this->params['breadcrumbs'][] = ['label' => 'Термінали', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['inscription_object_title'] = 'Термінали';
$this->params['inscription_object_explanation'] = 'Додавання терміналу';
?>
<div class="terminals-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
