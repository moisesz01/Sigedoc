<?php

namespace app\controllers;

use Yii;
use app\models\Documento;
use app\models\UsuarioProceso;
use app\models\Proceso;
use app\models\Respuesta;
use app\models\Opcion;
use app\models\Campo;
use app\models\Tipo;
use app\models\DocumentoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

/**
 * DocumentoController implements the CRUD actions for Documento model.
 */
class DocumentoController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Documento models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DocumentoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Documento model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Documento model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $user = Yii::$app->user->id;
        $model = new Documento();
        /*$userProceso = UsuarioProceso::find()->where(['usuario_idusuario'=>$user])->all();
        print_r($userProceso);die;
        $procesos = Proceso::find()->where(['id'=>$userProceso->proceso_id])->all();*/


        $query = new Query;   //// Consulta para obtener el proceso del usuario actual
        $query  ->select([
            'proceso.id',
            'proceso.pr_nombre',
        ]) 
            ->from('proceso')
            ->join('JOIN', 'usuario_proceso',
                        'usuario_proceso.proceso_id=proceso.id')
            ->where('usuario_proceso.usuario_idusuario=:id', [':id' => $user]);
            
        $command = $query->createCommand();
        $procesos = $command->queryAll();
        

        if ($model->load(Yii::$app->request->post()) /*&& $model->save()*/) {

            /*
                Se carga las respuestas asociadas a cada campo del documento
            */

            $respuesta = $_POST['DOCUMENTO']['field']; // este vector contiene las respuestas a los campos asociados al documento
            $pregunta_id = $_POST['DOCUMENTO']['field_id']; // este vector contiene los id de los campos, provienen del hiddenInput creado

            for ($i=0; $i < count($respuesta) ; $i++) { //se recorre todas las respuestas
                
                if($respuesta[$i]!=""){ //si los campos eran obligatorios el campo será diferente de vacio
                    
                    $modelCampo = Campo::find()->where(['id'=>$pregunta_id[$i]])->one();
                    if($modelCampo->ca_multiopc=='s'){//en caso de que el campo tenga opciones se busca su id para obtener el valor de la opcion

                        $tipo = Tipo::find()->where(['id'=>$modelCampo->tipo_id])->one();
                        $opcion = Opcion::find()->where(['tipo_id'=>$tipo->id])->one();
                        $modelRespuesta = new Respuesta;
                        $modelRespuesta->re_respuesta = $opcion->op_nombre;
                        $modelRespuesta->campo_id = $pregunta_id[$i];
                        $modelRespuesta->documento_iddocumento = $model->iddocumento;
                        $modelRespuesta->save();

                    }else{ //sino es un campo con opciones se carga el valor introducido en el campo

                        $modelRespuesta = new Respuesta;
                        $modelRespuesta->re_respuesta = $respuesta[$i];
                        $modelRespuesta->campo_id = $pregunta_id[$i];
                        $modelRespuesta->documento_iddocumento = $model->iddocumento;
                        $modelRespuesta->save();

                    }
                }
                else //si el campo no es obligatorio se guarda el caracter "."
                {
                    $modelRespuesta = new Respuesta;
                    $modelRespuesta->re_respuesta = '.';
                    $modelRespuesta->campo_id = $pregunta_id[$i];
                    $modelRespuesta->documento_iddocumento = $model->iddocumento;
                    $modelRespuesta->save();
                    $modelRespuesta->getErrors();

                }  
            
            }
            /*
                Creación del flujo del documento
            */
            $docFlujo = new DocumentoFlujo;
            $docFlujo->proceso_flujo_id
            $docFlujo->usuario_idusuario
            $docFlujo->documento_iddocumento = $model->iddocumento;




            /*
                Creación del buzon del documento
            */
            

            /* 
                Creación del directorio donde se guardará los documentos:
                -Se crea una carpeta en el directorio especificado en la creación del proceso
                -La carpeta tendra 8 caracteres aleatorios seguidos del caracter "&"
                -luego del caracter "&" tendra el nombre de referencia dado al documento creado
            */
            $directorio = Yii::$app->security->generateRandomString(8).'_'.$model->do_referencia;
            $ruta = Proceso::getDirectorio($model->proceso_id).'/';
            $ruta .= $directorio;            
            $file = mkdir($ruta, 0777, true);

            
            /*
                Carga de los archivos subidos al modelo de requerimientos
            */
            $recaudos = UploadedFile::getInstancesByName('Requerimiento'); // array que contiene todos los archivos adjuntos
            if(isset($_POST["RequerimientoID"])){
                $recaudos_id = $_POST['RequerimientoID']; // vector que contiene los id de requerimientos
                foreach ($recaudos as $key => $recaudo) { //se recorren los requerimientos para ir guardandolos
                    
                    $nombre = str_replace(' ', '', strtolower($recaudo->name)); 
                    $nombre = Yii::$app->security->generateRandomString(8).'_'.$nombre;
                    $type = explode("/", $recaudo->type);
                    $type = $type[1];
                    
                    if ($recaudo->saveAs($ruta.'/'.$nombre)) {
                        $docDigital = new Documentodigital;
                        $docDigital->requerimiento_id = $recaudos_id[$key];
                        $docDigital->dd_nombre = $nombre;
                        $docDigital->dd_ruta = \Yii::$app->request->BaseUrl.'/'.$ruta.'/'.$nombre;
                        $docDigital->dd_tipo = $type;
                        $docDigital->save();
                    }
                    
                }

            }
            
            die;    

            return $this->redirect(['view', 'id' => $model->iddocumento]);

        } else {
            return $this->render('create', [
                'model' => $model,
                'procesos' => $procesos,
            ]);
        }
    }

    /**
     * Updates an existing Documento model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionGetcampos(){
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $idproceso = explode(":", $data['idproceso']);
            $idproceso = $idproceso[0];            
            
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $query = new Query;   
            $query  ->select([
                'campo.id',
                'campo.ca_nombre',
                'campo.ca_obligatorio',
                'campo.ca_multiopc',
                'campo.tipo_id',
                'campo.proceso_id',

            ]) 
            ->from('campo')
            ->join('JOIN', 'proceso',
                        'campo.proceso_id=proceso.id')
            ->where('proceso.id=:id', [':id' => $idproceso]);            
            $command = $query->createCommand();
            $campos = $command->queryAll();
            return $this->renderAjax('_campos',['campos'=>$campos,'idproceso'=>$idproceso]);
        }

    }
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->iddocumento]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Documento model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Documento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Documento the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Documento::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
