<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'СКП | Вхід';
?>
<div class="site-login">
    <h1>Вхід</h1>

    <p>Будь ласка, заповніть наступні поля для входу на СКП аеропорту "Бориспіль":</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <div style="color:#999;margin:1em 0">
                    Якщо ви забули свій пароль --  <?= Html::a('натисніть сюди', ['auth/request-password-reset']) ?>,
                    якщо ж ви ще не зареєстровані в СКП аеропорта "Бориспіль", то ви можете зробити це <?= Html::a('тут', ['auth/request-password-reset']) ?>.
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Вхід', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
