<?php

use yii\helpers\Html;
use yii\grid\GridView;

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

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'usuario_idusuario',
            'actividad_idactividad',
            'proceso_id',
            'flujo_idflujo',
            // 'pf_orden',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
