<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <?php if (!Yii::$app->user->isGuest) : ?>
                <p><?= Yii::$app->user->identity->username;?></p>
                <?php endif; ?>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => 'Menu Sigedoc', 'options' => ['class' => 'header']],
                    [
                        'label' => 'Proceso',
                        'icon' => 'fa fa-share',
                        'url' => '#',
                        'visible' => (Yii::$app->user->can('Administrar Proceso')),
                        'items' => [
                            ['label' => 'Administrar Procesos', 'icon' => 'fa fa-file-code-o', 'url' => ['/proceso/index']],
                            ['label' => 'Crear Proceso', 'icon' => 'fa fa-file-code-o', 'url' => ['/proceso/create']],
                           
                        ],
                    ],
                    [
                        'label' => 'Flujo',
                        'icon' => 'fa fa-share',
                        'url' => '#',
                        'visible' => (Yii::$app->user->can('Administrar Flujo')),
                        'items' => [
                            ['label' => 'Administrar Flujo', 'icon' => 'fa fa-file-code-o', 'url' => ['/flujo/index']],
                            ['label' => 'Crear Flujo', 'icon' => 'fa fa-file-code-o', 'url' => ['/flujo/create']],
                           
                        ],
                    ],
                    [
                        'label' => 'Actividad',
                        'icon' => 'fa fa-share',
                        'url' => '#',
                        'visible' => (Yii::$app->user->can('Administrar Flujo')),
                        'items' => [
                            ['label' => 'Administrar Actividades', 'icon' => 'fa fa-file-code-o', 'url' => ['/actividad/index']],
                            ['label' => 'Crear Actividad', 'icon' => 'fa fa-file-code-o', 'url' => ['/actividad/create']],
                           
                        ],
                    ],
                    [
                        'label' => 'Flujo del Documento',
                        'icon' => 'fa fa-share',
                        'url' => '#',
                        'visible' => (Yii::$app->user->can('Administrar Flujo')),
                        'items' => [
                            ['label' => 'Administrar Flujo Proceso', 'icon' => 'fa fa-file-code-o', 'url' => ['/proceso-flujo/index']],
                            ['label' => 'Crear Flujo Proceso ', 'icon' => 'fa fa-file-code-o', 'url' => ['/proceso-flujo/create']],
                           
                        ],
                    ],
                    [
                        'label' => 'Tipo de Dato',
                        'icon' => 'fa fa-share',
                        'url' => '#',
                        'visible' => (Yii::$app->user->can('Administrar Flujo')),
                        'items' => [
                            ['label' => 'Administrar tipo de Dato', 'icon' => 'fa fa-file-code-o', 'url' => ['/tipo/index']],
                            ['label' => 'Crear tipo de Dato ', 'icon' => 'fa fa-file-code-o', 'url' => ['/tipo/create']],
                           
                        ],
                    ],
                    [
                        'label' => 'Gestionar Documento',
                        'icon' => 'fa fa-share',
                        'url' => '#',
                        'visible' => (Yii::$app->user->can('Administrar Documento')),
                        'items' => [
                            ['label' => 'Administrar Documento', 'icon' => 'fa fa-file-code-o', 'url' => ['/documento/index']],
                            ['label' => 'Crear Documento', 'icon' => 'fa fa-file-code-o', 'url' => ['/documento/create']],
                           
                        ],
                    ],
                    [
                        'label' => 'Flujo del Documento',
                        'icon' => 'fa fa-share',
                        'url' => '#',
                        'visible' => (Yii::$app->user->can('Administrar Documento')),
                        'items' => [
                            ['label' => 'Administrar Flujo', 'icon' => 'fa fa-file-code-o', 'url' => ['/documento/flujodocumento']],
                            
                           
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
