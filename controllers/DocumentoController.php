<?php

namespace app\controllers;

use Yii;
use app\models\Documento;
use app\models\UsuarioProceso;
use app\models\Proceso;
use app\models\ProcesoFlujo;
use app\models\DocumentoFlujo;
use app\models\Respuesta;
use app\models\Observacion;
use app\models\Opcion;
use app\models\Campo;
use app\models\Tipo;
use app\models\Buzondocumento;
use app\models\Requerimiento;
use app\models\DocumentoSearch;
use app\models\DocumentoDigital;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\data\Pagination;

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

        $DocumentoFlujo = DocumentoFlujo::find()->where(['documento_iddocumento'=>$id])->one();
        $Recaudos = DocumentoDigital::find()->where(['documento_flujo_iddocumento_actividad'=>$DocumentoFlujo->iddocumento_actividad])->all();
        $query = new Query;
        $query->select([
            
            'campo.ca_nombre AS campo',
            'respuesta.re_respuesta AS respuesta'
        ])
        ->from('campo')
        ->join('JOIN','respuesta','respuesta.campo_id=campo.id')
        ->where('respuesta.documento_iddocumento=:iddocumento',[':iddocumento'=>$id]);
        $command = $query->createCommand();
        $campos = $command->queryAll();
        

        return $this->render('view', [
            'model' => $this->findModel($id),
            'Recaudos' => $Recaudos,
            'campos' => $campos,
        ]);
    }

    /**
     * Creates a new Documento model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionDescargar($id){

        $file = DocumentoDigital::find()->where(['iddocumentodigital'=>$id])->one();
        $file = \Yii::getAlias('@webroot').$file->dd_url;
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.basename($file));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            exit;
        }
        else{

        }

    }
    public function getFecha(){

        $tz = 'America/Caracas';
        $timestamp = time();
        $dt = new \DateTime("now", new \DateTimeZone($tz)); 
        $dt->setTimestamp($timestamp);
        
        return $dt->format('Y-m-d H:i:s');

    }
    public function getUserConnect(){
        return Yii::$app->user->id;
    }
    public function actionCreate()
    {
        $user = $this->getUserConnect();
        $model = new Documento();
        

        $query = new Query;   // Consulta para obtener los proceso que el usuario actual puede crear documentos
        $query  ->select([
            'proceso.id',
            'proceso.pr_nombre',
        ]) 
            ->from('proceso')
            ->join('JOIN', 'usuario_proceso',
                        'usuario_proceso.proceso_id=proceso.id')
            ->join('JOIN', 'proceso_flujo',
                        'proceso.id = proceso_flujo.proceso_id')
            ->where('usuario_proceso.usuario_idusuario=:id and proceso_flujo.pf_orden=:orden', [':id' => $user,':orden'=>0]);
            
        $command = $query->createCommand();
        $procesos = $command->queryAll();
        

        if ($model->load(Yii::$app->request->post()) && $model->save()) {            

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
                    
                }  
            
            }
            /*
                Creación del flujo del documento
            */
            $proFlujo = ProcesoFlujo::find()->where(['pf_orden'=>0,'proceso_id'=>$model->proceso_id])->one();    
            $docFlujo = new DocumentoFlujo; 
            $docFlujo->proceso_flujo_id = $proFlujo->id;
            $docFlujo->usuario_idusuario =  $user;
            $docFlujo->documento_iddocumento = $model->iddocumento;
            $docFlujo->do_fechaini = $this->getFecha();
            $docFlujo->do_fecha_fin = $this->getFecha();
            $docFlujo->do_estado = "p";
            $docFlujo->save();

            

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
                        $docDigital->documento_flujo_iddocumento_actividad = $docFlujo->iddocumento_actividad;
                        $docDigital->dd_nombre = $nombre;
                        $docDigital->dd_ruta = '/'.$ruta;
                        $docDigital->dd_url = '/'.$ruta.'/'.$nombre;
                        $docDigital->dd_tipo = $type;
                        $docDigital->save();
                    }
                    
                }

            }
            
            /*
                Creación del buzon del documento y flujo de documento del usuario siguiente al actual
            */
            $proFlujo = ProcesoFlujo::find()->where(['pf_orden'=>1,'proceso_id'=>$model->proceso_id])->one();    
            $buzon = new Buzondocumento;
            $buzon->documento_iddocumento = $model->iddocumento;
            $buzon->bd_userorigen = $user;
            $buzon->bd_userdestino = $proFlujo->usuario_idusuario;
            $buzon->bd_estado ='a';
            $buzon->bd_fechaentrada = $this->getFecha();
            $buzon->save();

            $docFlujo = new DocumentoFlujo; 
            $docFlujo->proceso_flujo_id = $proFlujo->id;
            $docFlujo->usuario_idusuario =  $proFlujo->usuario_idusuario;
            $docFlujo->documento_iddocumento = $model->iddocumento;
            $docFlujo->do_fechaini = $this->getFecha();            
            $docFlujo->do_estado = "a";
            $docFlujo->save();

            return $this->redirect(['view', 'id' => $model->iddocumento]);

        } else {
            return $this->render('create', [
                'model' => $model,
                'procesos' => $procesos,
            ]);
        }
    }
    public function actionProcesar($id){
        

        $DocumentoFlujo = DocumentoFlujo::find()->where(['documento_iddocumento'=>$id])->one();
        $Recaudos = DocumentoDigital::find()->where(['documento_flujo_iddocumento_actividad'=>$DocumentoFlujo->iddocumento_actividad])->all();
        $query = new Query;
        $query->select([
            
            'campo.ca_nombre AS campo',
            'respuesta.re_respuesta AS respuesta'
        ])
        ->from('campo')
        ->join('JOIN','respuesta','respuesta.campo_id=campo.id')
        ->where('respuesta.documento_iddocumento=:iddocumento',[':iddocumento'=>$id]);
        $command = $query->createCommand();
        $campos = $command->queryAll();

        $query = new Query;
        $query->select([
            'buzondocumento.bd_userdestino AS usuario',
            'observacion.ob_observacion As observacion',
        ])
        ->from('buzondocumento')
        ->join('JOIN','observacion','observacion.buzondocumento_idbuzondocumento=buzondocumento.idbuzondocumento')
        ->where('buzondocumento.documento_iddocumento=:iddocumento',[':iddocumento'=>$id]);
        $command = $query->createCommand();
        $observaciones = $command->queryAll();
        $modelObservacion = new Observacion;

        if ($modelObservacion->load(Yii::$app->request->post())) {  
            
            if(!isset($_POST['aprobar']) && !isset($_POST['flujoIni']) ){                
                

                $Buzon = buzondocumento::find()->where(['bd_estado'=>'a','documento_iddocumento'=>$id])->one();
                $Buzon->bd_fechasalida = $this->getFecha();
                $Buzon->bd_estado = 'p';
                $Buzon->save();

                $modelObservacion->ob_observacion;
                $modelObservacion->buzondocumento_idbuzondocumento = $Buzon->idbuzondocumento;
                $modelObservacion->save();

                $docFlujo = DocumentoFlujo::find()->where(['do_estado'=>'a','documento_iddocumento'=>$id])->one();
                $docFlujo->do_fecha_fin = $this->getFecha();            
                $docFlujo->do_estado = 'r';
                $docFlujo->save();

                $idProcesoFlujo = $docFlujo->proceso_flujo_id;
                $ProcesoFlujo = ProcesoFlujo::find()->where(['id'=>$idProcesoFlujo])->one();
                $orden = $ProcesoFlujo->pf_orden;
                $ProcesoFlujoIni = ProcesoFlujo::find()->where(['pf_orden' => 0,'proceso_id' => $ProcesoFlujo->proceso_id])->one();

                $NewDocFlujo = new DocumentoFlujo;
                $NewDocFlujo->proceso_flujo_id = $ProcesoFlujoIni->id;
                $NewDocFlujo->do_fechaini = $this->getFecha();
                $NewDocFlujo->usuario_idusuario = $ProcesoFlujoIni->usuario_idusuario;
                $NewDocFlujo->documento_iddocumento = $id;
                $NewDocFlujo->do_estado = 'a';
                $NewDocFlujo->save();

                $Buzon = new buzondocumento;
                $Buzon->bd_fechaentrada = $this->getFecha();
                $Buzon->bd_estado = 'a';
                $Buzon->bd_userorigen = $this->getUserConnect();
                $Buzon->bd_userdestino = $ProcesoFlujoIni->usuario_idusuario;
                $Buzon->documento_iddocumento = $id;
                $Buzon->save();

                Yii::$app->session->setFlash('error','El Documento ha sido enviado a revisión');
                return $this->goHome();

            }
            else if( isset($_POST['aprobar']) || isset($_POST['flujoIni']) ){

                $Buzon = buzondocumento::find()->where(['bd_estado'=>'a','documento_iddocumento'=>$id])->one();
                $Buzon->bd_fechasalida = $this->getFecha();
                $Buzon->bd_estado = 'p';
                $Buzon->save();

                $modelObservacion->ob_observacion;
                $modelObservacion->buzondocumento_idbuzondocumento = $Buzon->idbuzondocumento;
                $modelObservacion->save();

                $docFlujo = DocumentoFlujo::find()->where(['do_estado'=>'a','documento_iddocumento'=>$id])->one();
                $docFlujo->do_fecha_fin = $this->getFecha();            
                $docFlujo->do_estado = 'p';
                $docFlujo->save();

                $idProcesoFlujo = $docFlujo->proceso_flujo_id;
                $ProcesoFlujo = ProcesoFlujo::find()->where(['id'=>$idProcesoFlujo])->one();
                $orden = $ProcesoFlujo->pf_orden;
                $ProcesoFlujoNext = ProcesoFlujo::find()->where(['pf_orden' => $orden+1,'proceso_id' => $ProcesoFlujo->proceso_id])->one();

                if($ProcesoFlujoNext){

                    $NewDocFlujo = new DocumentoFlujo;
                    $NewDocFlujo->proceso_flujo_id = $ProcesoFlujoNext->id;
                    $NewDocFlujo->do_fechaini = $this->getFecha();
                    $NewDocFlujo->usuario_idusuario = $ProcesoFlujoNext->usuario_idusuario;
                    $NewDocFlujo->documento_iddocumento = $id;
                    $NewDocFlujo->do_estado = 'a';
                    $NewDocFlujo->save();

                    $Buzon = new buzondocumento;
                    $Buzon->bd_fechaentrada = $this->getFecha();
                    $Buzon->bd_estado = 'a';
                    $Buzon->bd_userorigen = $this->getUserConnect();
                    $Buzon->bd_userdestino = $ProcesoFlujoNext->usuario_idusuario;
                    $Buzon->documento_iddocumento = $id;
                    $Buzon->save();
                    if(isset($_POST['flujoIni'])){
                         return $this->redirect(['actualizar','id'=>$id]); 
                    }

                    Yii::$app->session->setFlash('success','El Documento ha sido procesado con éxito y fue enviado a verificación');
                    return $this->goHome();

                }else{
                    $docFlujo->do_estado = 'f';
                    $docFlujo->save();
                    Yii::$app->session->setFlash('success','El Documento ha sido procesado con éxito y culminado su flujo de trabajo');
                    return $this->goHome();
                }
                
            }
           
        }

        return $this->render('procesar', [
            'model' => $this->findModel($id),
            'Recaudos' => $Recaudos,
            'campos' => $campos,
            'observaciones' =>$observaciones,
            'modelObservacion'=>$modelObservacion,
        ]);
    }

    /**
     * Updates an existing Documento model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */

    public function actionActualizar($id){

        $model = $this->findModel($id);


        $DocumentoFlujo = DocumentoFlujo::find()->where(['documento_iddocumento'=>$id])->one();
        $recaudos = DocumentoDigital::find()->where(['documento_flujo_iddocumento_actividad'=>$DocumentoFlujo->iddocumento_actividad])->all();
        $query = new Query;
        $query->select([
            
            'campo.ca_nombre AS campo',
            'campo.id',
            'campo.ca_nombre',
            'campo.ca_obligatorio',
            'campo.ca_multiopc',
            'campo.tipo_id',
            'campo.proceso_id',
            'respuesta.re_respuesta AS respuesta',
            'respuesta.idrespuesta AS idrespuesta'
            
        ])
        ->from('campo')
        ->join('JOIN','respuesta','respuesta.campo_id=campo.id')
        ->where('respuesta.documento_iddocumento=:iddocumento',[':iddocumento'=>$id]);
        $command = $query->createCommand();
        $campos = $command->queryAll();

        $query = new Query;
        $query->select([
            'buzondocumento.bd_userdestino AS usuario',
            'observacion.ob_observacion As observacion',
        ])
        ->from('buzondocumento')
        ->join('JOIN','observacion','observacion.buzondocumento_idbuzondocumento=buzondocumento.idbuzondocumento')
        ->where('buzondocumento.documento_iddocumento=:iddocumento',[':iddocumento'=>$id]);
        $command = $query->createCommand();
        $observaciones = $command->queryAll();
        $modelObservacion = new Observacion;


        if ($model->load(Yii::$app->request->post())) {  

            if (isset($_POST['idrecaudo'])) {
                $idrecaudos = $_POST['idrecaudo'];
                $recaudos = UploadedFile::getInstancesByName('recaudo');    
                foreach ($recaudos as $key => $recaudo) { //se recorren los requerimientos para ir guardandolos
                    $idrecaudo = $idrecaudos[$key];
                    $nombre = str_replace(' ', '', strtolower($recaudo->name)); 
                    $nombre = Yii::$app->security->generateRandomString(8).'_'.$nombre;
                    $type = explode("/", $recaudo->type);
                    $type = $type[1];
                    $docDigital = Documentodigital::find()->where(['iddocumentodigital'=>$idrecaudo])->one();
                    $ruta = $docDigital->dd_ruta;
                    if ($recaudo->saveAs(\Yii::getAlias('@webroot').$ruta.'/'.$nombre)) {
                        
                        $docDigital->dd_nombre = $nombre;
                        $docDigital->dd_url = $ruta.'/'.$nombre;
                        $docDigital->dd_tipo = $type;
                        $docDigital->save();

                    }
                    
                }

            }
            
            $Buzon = buzondocumento::find()->where(['bd_estado'=>'a','documento_iddocumento'=>$id])->one();
            $Buzon->bd_fechasalida = $this->getFecha();
            $Buzon->bd_estado = 'p';
            $Buzon->save();
            $modelObservacion->ob_observacion = $_POST['Observacion']['ob_observacion'];
            $modelObservacion->buzondocumento_idbuzondocumento = $Buzon->idbuzondocumento;
            $modelObservacion->save();
            

            $docFlujo = DocumentoFlujo::find()->where(['do_estado'=>'a','documento_iddocumento'=>$id])->one();
            $docFlujo->do_fecha_fin = $this->getFecha();            
            $docFlujo->do_estado = 'p';
            $docFlujo->save();

            $idProcesoFlujo = $docFlujo->proceso_flujo_id;
            $ProcesoFlujo = ProcesoFlujo::find()->where(['id'=>$idProcesoFlujo])->one();
            $orden = $ProcesoFlujo->pf_orden;
            $ProcesoFlujoNext = ProcesoFlujo::find()->where(['pf_orden' => $orden+1,'proceso_id' => $ProcesoFlujo->proceso_id])->one();

            if($ProcesoFlujoNext){

                $NewDocFlujo = new DocumentoFlujo;
                $NewDocFlujo->proceso_flujo_id = $ProcesoFlujoNext->id;
                $NewDocFlujo->do_fechaini = $this->getFecha();
                $NewDocFlujo->usuario_idusuario = $ProcesoFlujoNext->usuario_idusuario;
                $NewDocFlujo->documento_iddocumento = $id;
                $NewDocFlujo->do_estado = 'a';
                $NewDocFlujo->save();

                $Buzon = new buzondocumento;
                $Buzon->bd_fechaentrada = $this->getFecha();
                $Buzon->bd_estado = 'a';
                $Buzon->bd_userorigen = $this->getUserConnect();
                $Buzon->bd_userdestino = $ProcesoFlujoNext->usuario_idusuario;
                $Buzon->documento_iddocumento = $id;
                $Buzon->save();
                
            }

            $respuesta = $_POST['DOCUMENTO']['field']; 
            $pregunta_id = $_POST['DOCUMENTO']['field_id'];
            $respuesta_id = $_POST['DOCUMENTO']['field_resp'];

            for ($i=0; $i < count($respuesta) ; $i++) { //se recorre todas las respuestas

                if($respuesta[$i]!=""){ //si los campos eran obligatorios el campo será diferente de vacio
                    
                    $modelCampo = Campo::find()->where(['id'=>$pregunta_id[$i]])->one();

                    if($modelCampo->ca_multiopc=='s'){//en caso de que el campo tenga opciones se busca su id para obtener el valor de la opcion
                        
                        $opcion = Opcion::find()->where(['id'=>$respuesta[$i]])->one();
                        $modelRespuesta = Respuesta::find()->where(['idrespuesta'=>$respuesta_id[$i]])->one();
                        $modelRespuesta->re_respuesta = $opcion->op_nombre;
                        $modelRespuesta->save();

                    }else{ //sino es un campo con opciones se carga el valor introducido en el campo

                        $modelRespuesta = Respuesta::find()->where(['idrespuesta'=>$respuesta_id[$i]])->one();
                        $modelRespuesta->re_respuesta = $respuesta[$i];
                        $modelRespuesta->save();

                    }
                }
                else //si el campo no es obligatorio se guarda el caracter "."
                {
                    $modelRespuesta = Respuesta::find()->where(['idrespuesta'=>$respuesta_id[$i]])->one();
                    $modelRespuesta->re_respuesta = '.';
                    $modelRespuesta->save();
                }  
            
            }
            $model->save();
            
            Yii::$app->session->setFlash('success','El Documento ha sido procesado con éxito.');
            return $this->goHome();
        }
        
        return $this->render('update',[
            'model'=>$model,
            'recaudos'=>$recaudos,
            'campos'=>$campos,
            'observaciones'=>$observaciones,
            'modelObservacion'=>$modelObservacion,
            
        ]);



    }
    public function actionFlujodocumento(){

        $searchModel = new DocumentoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('flujo_documento', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }
    public function actionBuzon(){
        $userID = $this->getUserConnect();
        $BuzonDocumento = BuzonDocumento::find()->where(['bd_estado'=>'a','bd_userdestino'=>$userID]);
        $count = clone $BuzonDocumento;
        $pagination = new Pagination([
            'pagesize'=>10,
            'totalCount'=>$count->count(),
        ]);
        $buzon = $BuzonDocumento
                ->offset($pagination->offset)
                ->limit($pagination->limit)
                ->all();
     
        return $this->render('buzon', [
            'BuzonDocumento'=>$buzon,
            'pagination'=>$pagination,
        ]);
    }
    public function actionFlujo($id){

        $query = new query();
        $query->select([
            'flujo.fl_nombre AS flujo',
            'proceso.pr_nombre AS proceso',
            'actividad.ac_nombre AS actividad',
            'user.username AS usuario',
            'documento_flujo.do_fechaini AS fechaini',
            'documento_flujo.do_fecha_fin AS fechafin'
        ])
        ->from('documento_flujo')
        ->join('JOIN','proceso_flujo','documento_flujo.proceso_flujo_id=proceso_flujo.id')
        ->join('JOIN','proceso','proceso_flujo.proceso_id=proceso.id')
        ->join('JOIN','flujo','proceso_flujo.flujo_idflujo=flujo.idflujo')
        ->join('JOIN','actividad','proceso_flujo.actividad_idactividad=actividad.idactividad')
        ->join('JOIN','user','proceso_flujo.usuario_idusuario="user".id')
        ->where('documento_iddocumento=:id',[':id'=>$id]);
        $command = $query->createCommand();
        $DocumentoFlujo = $command->queryAll(); 
        $Flujo = DocumentoFlujo::find()->where(['documento_iddocumento'=>$id])->orderBy([
               'iddocumento_actividad'=>SORT_DESC,    
        ])->one();
        $proceso = Documento::find()->where(['iddocumento'=>$id])->one(); 
        $query = new query();
        $query->select([
            'flujo.fl_nombre AS flujo',
            'proceso.pr_nombre AS proceso',
            'actividad.ac_nombre AS actividad',
            'user.username AS usuario',
            'proceso_flujo.pf_orden AS orden',
            'proceso_flujo.id AS id'
        ])
        ->from('proceso_flujo')
        ->join('JOIN','proceso','proceso_flujo.proceso_id=proceso.id')
        ->join('JOIN','flujo','proceso_flujo.flujo_idflujo=flujo.idflujo')
        ->join('JOIN','actividad','proceso_flujo.actividad_idactividad=actividad.idactividad')
        ->join('JOIN','user','proceso_flujo.usuario_idusuario="user".id')
        ->where('proceso_flujo.proceso_id=:id',[':id'=>$proceso->proceso_id])
        ->addOrderBy(['proceso_flujo.pf_orden'=>SORT_ASC]);

        $command = $query->createCommand();
        $transitar = $command->queryAll(); 
       

        return $this->render('flujoview',[
            'DocumentoFlujo'=>$DocumentoFlujo,
            'model' => $this->findModel($id),
            'transitar'=>$transitar,
            'flujo'=>$Flujo,
        ]);
    }

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
