<?php

namespace app\controllers;

use Yii;
use app\models\ProcesoFlujo;
use app\models\Requerimiento;
use app\models\ProcesoFlujoSearch;
use app\models\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProcesoFlujoController implements the CRUD actions for ProcesoFlujo model.
 */
class ProcesoFlujoController extends Controller
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
     * Lists all ProcesoFlujo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProcesoFlujoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProcesoFlujo model.
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
     * Creates a new ProcesoFlujo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProcesoFlujo;
        $modelsRequerimiento = [new Requerimiento];
        if ($model->load(Yii::$app->request->post())) {

            $modelsRequerimiento = Model::createMultiple(Requerimiento::classname());
            Model::loadMultiple($modelsRequerimiento, Yii::$app->request->post());

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsRequerimiento),
                    ActiveForm::validate($model)
                );
            }
            
            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsRequerimiento) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        foreach ($modelsRequerimiento as $modelRequerimiento) {
                            $modelRequerimiento->proceso_flujo_id = $model->id;
                            if (! ($flag = $modelRequerimiento->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();                
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'modelsRequerimiento' => (empty($modelsRequerimiento)) ? [new Campo] : $modelsRequerimiento
        ]);
    }

    /**
     * Updates an existing ProcesoFlujo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelsRequerimiento = $model->requerimientos;

        if ($model->load(Yii::$app->request->post())) {

            $oldIDs = ArrayHelper::map($modelsRequerimiento, 'id', 'id');
            $modelsRequerimiento = Model::createMultiple(Campo::classname(), $modelsRequerimiento);
            Model::loadMultiple($modelsRequerimiento, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsRequerimiento, 'id', 'id')));

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsRequerimiento),
                    ActiveForm::validate($model)
                );
            }

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsRequerimiento) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (! empty($deletedIDs)) {
                            Requerimiento::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelsRequerimiento as $modelRequerimiento) {
                            $modelRequerimiento->proceso_flujo_id = $model->id;
                            if (! ($flag = $modelRequerimiento->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'modelsRequerimiento' => (empty($modelsRequerimiento)) ? [new Requerimiento] : $modelsRequerimiento
        ]);
    }

    /**
     * Deletes an existing ProcesoFlujo model.
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
     * Finds the ProcesoFlujo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProcesoFlujo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProcesoFlujo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
