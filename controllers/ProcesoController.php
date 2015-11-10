<?php

namespace app\controllers;

use Yii;
use app\models\Proceso;
use app\models\Campo;
use app\models\Model;
use app\models\Opcion;
use app\models\ProcesoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * ProcesoController implements the CRUD actions for Proceso model.
 */
class ProcesoController extends Controller
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
     * Lists all Proceso models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProcesoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Proceso model.
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
     * Creates a new Proceso model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $modelProceso = new Proceso;
        $modelsCampo = [new Campo];
        if ($modelProceso->load(Yii::$app->request->post())) {

            $modelsCampo = Model::createMultiple(Campo::classname());
            Model::loadMultiple($modelsCampo, Yii::$app->request->post());

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsCampo),
                    ActiveForm::validate($modelProceso)
                );
            }
            
            // validate all models
            $valid = $modelProceso->validate();
            $valid = Model::validateMultiple($modelsCampo) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelProceso->save(false)) {
                        foreach ($modelsCampo as $modelCampo) {
                            $modelCampo->proceso_id = $modelProceso->id;
                            $campo = Opcion::find()->where(['tipo_id'=>$modelCampo->tipo_id])->one();
                            if($campo)
                                $modelCampo->ca_multiopc='s';
                            else
                                $modelCampo->ca_multiopc='n';
                            
                            if (! ($flag = $modelCampo->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $modelProceso->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('create', [
            'modelProceso' => $modelProceso,
            'modelsCampo' => (empty($modelsCampo)) ? [new Campo] : $modelsCampo
        ]);
    }

    /**
     * Updates an existing Proceso model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    /*public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }*/
    public function actionUpdate($id)
    {
        $modelProceso = $this->findModel($id);
        $modelsCampo = $modelProceso->campos;

        if ($modelProceso->load(Yii::$app->request->post())) {

            $oldIDs = ArrayHelper::map($modelsCampo, 'id', 'id');
            $modelsCampo = Model::createMultiple(Campo::classname(), $modelsCampo);
            Model::loadMultiple($modelsCampo, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsCampo, 'id', 'id')));

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsCampo),
                    ActiveForm::validate($modelProceso)
                );
            }

            // validate all models
            $valid = $modelProceso->validate();
            $valid = Model::validateMultiple($modelsCampo) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelProceso->save(false)) {
                        if (! empty($deletedIDs)) {
                            Address::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelsCampo as $modelCampo) {
                            $modelCampo->proceso_id = $modelProceso->id;
                            if (! ($flag = $modelCampo->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $modelProceso->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('update', [
            'modelProceso' => $modelProceso,
            'modelsCampo' => (empty($modelsCampo)) ? [new Address] : $modelsCampo
        ]);
    }

    /**
     * Deletes an existing Proceso model.
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
     * Finds the Proceso model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Proceso the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Proceso::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
