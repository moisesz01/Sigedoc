<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\actividad */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Actividads', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Crear Actividad';
?>
<div class="actividad-create">

    <h1>Crear Actividad</h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
