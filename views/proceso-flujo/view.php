<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ProcesoFlujo */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Proceso Flujos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="proceso-flujo-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Borrar', ['delete', 'id' => $model->id], [
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
            'proceso.pr_nombre',
            'flujoIdflujo.fl_nombre',
            'actividadIdactividad.ac_nombre',
            'usuarioIdusuario.username',
            'pf_orden',
        ],
    ]) ?>
    <?php if($requerimientos):?>
        <h2>Requerimientos</h2>

        <table class="table table-striped table-bordered" style="text-align:center;">
            <tr>
              <td><strong>Nombre del Requerimiento</strong></td>
              <td><strong>Descripción del Requerimiento</strong></td>
              
            </tr>
             <?php foreach ($requerimientos as $requerimiento):?>
                <tr>
                  <td><?=$requerimiento['re_nombre']?></td>
                  <td><?=$requerimiento['re_descripcion']?></td>
                  
                </tr>
            <?php endforeach;?>
        </table> 

    <?php endif; ?>
    
<?= Html::a(' <span class="glyphicon glyphicon-circle-arrow-left"> </span>  Volver', ['proceso-flujo/index'] , ['class'=>'btn btn-success', 'style'=>'margin-top:20px;']) ?>

</div>
