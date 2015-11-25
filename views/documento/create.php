<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Documento */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Documentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = "Crear Documento";
?>
<div class="documento-create">

    <h1>Crear Documento</h1>

    <?= $this->render('_form', [
        'model' => $model,
        'procesos' => $procesos,
    ]) ?>

</div>
