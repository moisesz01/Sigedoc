<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Tipo */

$this->title = 'Update Tipo: ' . ' ' . $modelTipo->id;
$this->params['breadcrumbs'][] = ['label' => 'Tipos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelTipo->id, 'url' => ['view', 'id' => $modelTipo->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tipo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'modelTipo' => $modelTipo,
        'modelsOpcion' => (empty($modelsOpcion)) ? [new Opcion] : $modelsOpcion
    ]) ?>

</div>
