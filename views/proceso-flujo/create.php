<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ProcesoFlujo */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Proceso Flujos', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Crear Proceso Flujo';
?>
<div class="proceso-flujo-create">

    <h1>Crear Proceso Flujo</h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsRequerimiento' => (empty($modelsRequerimiento)) ? [new Campo] : $modelsRequerimiento,
    ]) ?>

</div>
