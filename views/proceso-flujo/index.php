<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProcesoFlujoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Proceso Flujos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="proceso-flujo-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Proceso Flujo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin();?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'proceso_id',
                'value' => 'proceso.pr_nombre',
            ],
            [
                'attribute' => 'usuario_idusuario',
                'value' => 'usuarioIdusuario.username',
            ],
            [
                'attribute' => 'actividad_idactividad',
                'value' => 'actividadIdactividad.ac_nombre',
            ],
            [
                'attribute' => 'flujo_idflujo',
                'value' => 'flujoIdflujo.fl_nombre',
            ],
            
            // 'pf_orden',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
