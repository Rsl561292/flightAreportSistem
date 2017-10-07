<?php

use adminlte\widgets\Menu;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
<?= Html::img('@web/img/user2-160x160.jpg', ['class' => 'img-circle', 'alt' => 'User Image']) ?>
            </div>
            <div class="pull-left info">
                <p><?= Yii::$app->user->identity->username?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <?=
        Menu::widget(
                [
                    'options' => ['class' => 'sidebar-menu'],
                    'items' => [
                        ['label' => 'Menu', 'options' => ['class' => 'header']],
                        ['label' => 'Панель приладів', 'icon' => 'fa fa-dashboard',
                            'url' => ['default/index'], 'active' => $this->context->route == 'default/index'
                        ],
                        [
                            'label' => 'Інфраструктура',
                            'icon' => 'fa fa-building-o',
                            'url' => '#',
                            'items' => [
                                [
                                    'label' => 'Термінали',
                                    'icon' => 'fa fa-building-o',
                                    'url' => ['terminals/index'],
				                    'active' => $this->context->route == 'terminals/index'
                                ],
                                [
                                    'label' => 'Реєстр. стійки',
                                    'icon' => 'fa fa-building-o',
                                    'url' => ['registration-desk/index'],
                                    'active' => $this->context->route == 'registration-desk/index'
                                ],
                                [
                                    'label' => 'Посадкові платформи',
                                    'icon' => 'fa fa-square-o',
                                    'url' => ['platform/index'],
                                    'active' => $this->context->route == 'platform/index'
                                ],
                            ]
                        ],
                        [
                            'label' => 'Локації',
                            'icon' => 'fa fa-building-o',
                            'url' => '#',
                            'items' => [
                                [
                                    'label' => 'Країни',
                                    'icon' => 'fa fa-building-o',
                                    'url' => ['country/index'],
                                    'active' => $this->context->route == 'country/index'
                                ],
                                [
                                    'label' => 'Регіони країн',
                                    'icon' => 'fa fa-building-o',
                                    'url' => ['regions/index'],
                                    'active' => $this->context->route == 'regions/index'
                                ],
                            ]
                        ],
                        ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii'],],
                    ],
                ]
        )
        ?>
        
    </section>
    <!-- /.sidebar -->
</aside>
