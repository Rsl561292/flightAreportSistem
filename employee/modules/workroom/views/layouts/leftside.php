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
                                [
                                    'label' => 'Льотні смуги',
                                    'icon' => 'fa fa-road',
                                    'url' => ['flight-strips/index'],
                                    'active' => $this->context->route == 'flight-strips/index'
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
                        [
                            'label' => 'Аеропорти',
                            'icon' => 'fa fa-opencart',
                            'url' => ['airports/index'],
                            'active' => $this->context->route == 'airports/index'
                        ],
                        [
                            'label' => 'Авіаперевізники',
                            'icon' => 'fa fa-fighter-jet',
                            'url' => ['carrier/index'],
                            'active' => $this->context->route == 'carrier/index'
                        ],
                        [
                            'label' => 'Повітряні судна',
                            'icon' => 'fa fa-plane',
                            'url' => '#',
                            'items' => [
                                [
                                    'label' => 'Повітряні судна',
                                    'icon' => 'fa fa-plane',
                                    'url' => ['plane/index'],
                                    'active' => $this->context->route == 'plane/index'
                                ],
                                [
                                    'label' => 'Моделі ПС',
                                    'icon' => 'fa fa-fighter-jet',
                                    'url' => ['plane-types/index'],
                                    'active' => $this->context->route == 'plane-types/index'
                                ],
                            ]
                        ],
                        [
                            'label' => 'Робота з польотами',
                            'icon' => 'fa fa-plane',
                            'url' => '#',
                            'items' => [
                                [
                                    'label' => 'Гріфіки польотів',
                                    'icon' => 'fa fa-bar-chart',
                                    'url' => ['flights/index'],
                                    'active' => $this->context->route == 'flights/index'
                                ],
                                [
                                    'label' => 'Гріфіки займання перонів',
                                    'icon' => 'fa fa-square-o',
                                    'url' => ['schedule-busy-platform/index'],
                                    'active' => $this->context->route == 'schedule-busy-platform/index'
                                ],
                                [
                                    'label' => 'Використання реєст. стійок',
                                    'icon' => 'fa fa-terminal',
                                    'url' => ['registration-desk-to-flight/index'],
                                    'active' => $this->context->route == 'registration-desk-to-flight/index'
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
