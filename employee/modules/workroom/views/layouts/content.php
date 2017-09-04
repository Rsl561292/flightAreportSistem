<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\widgets\AlertLte;

?>
	  <!-- Content Wrapper. Contains page content -->
	  <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
			<h1>
				<?php
					if(isset($this->params['inscription_object_title'])) {
						echo Html::encode($this->params['inscription_object_title']);
					}
				?>
				<small>
					<?php
						if(isset($this->params['inscription_object_explanation'])) {
							echo Html::encode($this->params['inscription_object_explanation']);
						}
					?>
				</small>
			</h1>

			<?=
			Breadcrumbs::widget([
				'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
			]) ?>
        </section>

        <!-- Main content -->
        <section class="content">
			<?php if(Yii::$app->session->hasFlash('success')):?>
				<div class="alert alert-success alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<h4><i class="icon fa fa-check"></i> Успіх!</h4>
					<?= Yii::$app->session->getFlash('success');?>
				</div>
			<?php else:?>
				<?php if(Yii::$app->session->hasFlash('error')):?>
					<div class="alert alert-danger alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<h4><i class="icon fa fa-ban"></i> Помилка!</h4>
						<?= Yii::$app->session->getFlash('error');?>
					</div>
				<?php endif;?>
			<?php endif;?>

			<?= $content ?>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
