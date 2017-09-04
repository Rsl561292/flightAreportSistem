<?php
use yii\helpers\Html;
?>
<header class="main-header">
        <!-- Logo -->
        <?= Html::a('
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>СКП</b></span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>СКП</b> | Кабінет</span>
        ', ['default/index'], ['class' => 'logo'])?>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<?= Html::img('@web/img/user2-160x160.jpg', ['class' => 'user-image', 'alt'=>'User Image']) ?>
                  <span class="hidden-xs"><?= Yii::$app->user->identity->username?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <?= Html::img('@web/img/user2-160x160.jpg', ['class' => 'img-circle', 'alt'=>'User Image']) ?>
                    <p>
                      <?= Yii::$app->user->identity->username?> - Веб розробник
                      <small>Зареєстрований в системі 22.08.2017</small>
                    </p>
                  </li>
                  <!-- Menu Body -->
                  <li class="user-body">
                    <div class="col-xs-6 text-center">
                      <?= Html::a('Налаштування системи', ['default/setting-system'])?>
                    </div>
                    <div class="col-xs-6 text-center">
                      <?= Html::a('Налаштування профілю', ['default/setting-profile'])?>
                    </div>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <?= Html::a('Сайт СКП', ['/workers'],['class' => 'btn btn-default btn-flat'])?>
                    </div>
                    <div class="pull-right">
                      <?= Html::a('Вихід з СКП', ['/auth/logout'],['class' => 'btn btn-default btn-flat'])?>
                    </div>
                  </li>
                </ul>
              </li>
              <!-- Control Sidebar Toggle Button -->
              <!--<li>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
              </li>-->
            </ul>
          </div>
        </nav>
      </header>
