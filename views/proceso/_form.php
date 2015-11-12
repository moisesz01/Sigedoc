<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\ArrayHelper;
use app\models\Tipo;
use yii\helpers\Json;
?>

<div class="customer-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($modelProceso, 'pr_referencia')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($modelProceso, 'pr_nombre')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-4" style="padding-top:30px;">
            <?= $form->field($modelProceso, 'pr_aprobacion')->checkbox() ?>
        </div>
        
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($modelProceso, 'pr_descripcion')->textarea(['rows' => 2]) ?>        
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($modelProceso, 'pr_directorio')->textarea(['rows' => 1,'onblur'=>"verificarDirectorio()"]) ?>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading"><h4><i class="glyphicon glyphicon-envelope"></i> Campos</h4></div>
        <div class="panel-body">
             <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                //'limit' => 4, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $modelsCampo[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'tipo_id',
                    'ca_nombre',
                ],
            ]); ?>

            <div class="container-items"><!-- widgetContainer -->
            <?php foreach ($modelsCampo as $i => $modelCampo): ?>
                <div class="item panel panel-default"><!-- widgetBody -->
                    <div class="panel-heading">
                        <h3 class="panel-title pull-left">Campo</h3>
                        <div class="pull-right">
                            <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <?php
                            // necessary for update action.
                            if (! $modelCampo->isNewRecord) {
                                echo Html::activeHiddenInput($modelCampo, "[{$i}]id");
                            }
                        ?>
                        
                        <div class="row">
                            <div class="col-sm-4">
                                <?=$form->field($modelCampo, "[{$i}]tipo_id")->dropDownList(
                                    ArrayHelper::map(Tipo::find()->all(),'id','ti_tipo'),
                                    ['prompt'=>'Seleccione Tipo...']); 
                                ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $form->field($modelCampo, "[{$i}]ca_nombre")->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-sm-4" style="padding-top:30px;">
                                <?= $form->field($modelCampo, "[{$i}]ca_obligatorio")->checkbox() ?>
                            </div>
                        </div><!-- .row -->
                        
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
            <?php DynamicFormWidget::end(); ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($modelCampo->isNewRecord ? 'Crear' : 'Actualizar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">
    
    function verificarDirectorio() {
        $.ajax({
           url: '<?php echo Yii::$app->request->baseUrl. '/proceso/directory' ?>',
           type: 'post',
           data: {directorio: $("#proceso-pr_directorio").val()},
           //data: {search: "hola"},
           success: function (data) {
                if (data.isDirectory==1) {
                    alert("Directorio existente");
                    $('#proceso-pr_directorio').val('');
                    $('#proceso-pr_directorio').focus();
                }
              
           }
        });
        
    }

</script>

