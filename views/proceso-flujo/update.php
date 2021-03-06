<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProcesoFlujo */

$this->title = 'Update Proceso Flujo: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Proceso Flujos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="proceso-flujo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
            'modelsRequerimiento' => (empty($modelsRequerimiento)) ? [new Requerimiento] : $modelsRequerimiento
    ]) ?>

</div>
