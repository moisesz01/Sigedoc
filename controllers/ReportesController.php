<?php

namespace app\controllers;

use Yii;
use app\models\ProductividadForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;


/**
 * ReportesController 
 */
class ReportesController extends Controller
{
    
    public function actionProductividad()
    {
        $modelProductividad = new ProductividadForm;
        if ($modelProductividad->load(Yii::$app->request->post())) {  
           
            $mensaje="hola mundo";
            return $this->render('productividad', [
                'mensaje'=>$mensaje,
                'modelProductividad'=>$modelProductividad,
            ]); 
        }
        return $this->render('productividad', [
            'modelProductividad'=>$modelProductividad,
        ]);
    }
    


}
