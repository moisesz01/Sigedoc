<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [

                    [
                        'label' => 'Proceso',
                        'icon' => 'fa fa-share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Administrar Procesos', 'icon' => 'fa fa-file-code-o', 'url' => ['/proceso/index'],'visible' => (Yii::$app->user->can('Administrar Proceso'))],
                            ['label' => 'Crear Proceso', 'icon' => 'fa fa-file-code-o', 'url' => ['/proceso/create'],'visible' => (Yii::$app->user->can('Administrar Proceso'))],
                           
                        ],
                    ],
                    [
                        'label' => 'Flujo',
                        'icon' => 'fa fa-share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Administrar Flujo', 'icon' => 'fa fa-file-code-o', 'url' => ['/flujo/index'],'visible' => (Yii::$app->user->can('Administrar Flujo'))],
                            ['label' => 'Crear Flujo', 'icon' => 'fa fa-file-code-o', 'url' => ['/flujo/create'],'visible' => (Yii::$app->user->can('Administrar Flujo'))],
                           
                        ],
                    ],
                    [
                        'label' => 'Actividad',
                        'icon' => 'fa fa-share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Administrar Actividades', 'icon' => 'fa fa-file-code-o', 'url' => ['/actividad/index'],'visible' => (Yii::$app->user->can('Administrar Flujo'))],
                            ['label' => 'Crear Actividad', 'icon' => 'fa fa-file-code-o', 'url' => ['/actividad/create'],'visible' => (Yii::$app->user->can('Administrar Flujo'))],
                           
                        ],
                    ],
                    [
                        'label' => 'Flujo del Documento',
                        'icon' => 'fa fa-share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Administrar Flujo Proceso', 'icon' => 'fa fa-file-code-o', 'url' => ['/proceso-flujo/index'],'visible' => (Yii::$app->user->can('Administrar Flujo'))],
                            ['label' => 'Crear Flujo Proceso ', 'icon' => 'fa fa-file-code-o', 'url' => ['/proceso-flujo/create'],'visible' => (Yii::$app->user->can('Administrar Flujo'))],
                           
                        ],
                    ],
                    [
                        'label' => 'Tipo de Dato',
                        'icon' => 'fa fa-share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Administrar tipo de Dato', 'icon' => 'fa fa-file-code-o', 'url' => ['/tipo/index'],'visible' => (Yii::$app->user->can('Administrar Flujo'))],
                            ['label' => 'Crear tipo de Dato ', 'icon' => 'fa fa-file-code-o', 'url' => ['/tipo/create'],'visible' => (Yii::$app->user->can('Administrar Flujo'))],
                           
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
