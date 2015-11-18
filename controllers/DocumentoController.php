<?php

namespace app\controllers;

use Yii;
use app\models\Documento;
use app\models\UsuarioProceso;
use app\models\Proceso;
use app\models\DocumentoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;

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
        

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
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
            ]) 
            ->from('campo')
            ->join('JOIN', 'proceso',
                        'campo.proceso_id=proceso.id')
            ->where('proceso.id=:id', [':id' => $idproceso]);            
            $command = $query->createCommand();
            $campos = $command->queryAll();
            return $this->renderAjax('_campos',['campos'=>$campos]);

            /*return [
                'isDirectory' => $idproceso,
            ];*/
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
