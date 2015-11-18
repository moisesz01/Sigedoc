<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Tipo */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Tipos', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Crear Tipo de Dato';
?>
<div class="tipo-create">

    <h1>Crear Tipo de Dato</h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsOpcion' => (empty($modelsOpcion)) ? [new Opcion] : $modelsOpcion
    ]) ?>

</div>
