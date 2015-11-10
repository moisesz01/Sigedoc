<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BuzondocumentoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Buzondocumentos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="buzondocumento-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Buzondocumento', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idbuzondocumento',
            'bd_fechaentrada',
            'bd_fechasalida',
            'bd_estado',
            'bd_userorigen',
            // 'bd_userdestino',
            // 'documento_iddocumento',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
