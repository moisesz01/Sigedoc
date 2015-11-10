<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Buzondocumento */

$this->title = 'Create Buzondocumento';
$this->params['breadcrumbs'][] = ['label' => 'Buzondocumentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="buzondocumento-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
