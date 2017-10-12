<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Carrier */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Carriers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carrier-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'identification_code',
            'name',
            'short_description:ntext',
            'country_id',
            'region_id',
            'city',
            'other_address',
            'phone',
            'email:email',
            'status',
            'description:ntext',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
