<?php

namespace app\controllers;

use Yii;
use app\models\Tipo;
use app\models\Model;
use app\models\Opcion;
use app\models\TipoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TipoController implements the CRUD actions for Tipo model.
 */
class TipoController extends Controller
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
     * Lists all Tipo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TipoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tipo model.
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
     * Creates a new Tipo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $modelTipo = new Tipo;
        $modelsOpcion = [new Opcion];
        if ($modelTipo->load(Yii::$app->request->post())) {

            $modelsOpcion = Model::createMultiple(Opcion::classname());
            Model::loadMultiple($modelsOpcion, Yii::$app->request->post());

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsOpcion),
                    ActiveForm::validate($modelTipo)
                );
            }

            // validate all models
            $valid = $modelTipo->validate();
            $valid = Model::validateMultiple($modelsOpcion) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelTipo->save(false)) {
                        foreach ($modelsOpcion as $modelOpcion) {
                            $modelOpcion->tipo_id = $modelTipo->id;
                            if (! ($flag = $modelOpcion->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $modelTipo->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('create', [
            'modelTipo' => $modelTipo,
            'modelsOpcion' => (empty($modelsOpcion)) ? [new Address] : $modelsOpcion
        ]);
    }

    /**
     * Updates an existing Tipo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $modelTipo = $this->findModel($id);
        $modelsOpcion = [new Opcion];

        if ($modelTipo->load(Yii::$app->request->post())) {

            $oldIDs = ArrayHelper::map($modelsOpcion, 'id', 'id');
            $modelsOpcion = Model::createMultiple(Opcion::classname(), $modelsOpcion);
            Model::loadMultiple($modelsOpcion, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsOpcion, 'id', 'id')));

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsOpcion),
                    ActiveForm::validate($modelTipo)
                );
            }

            // validate all models
            $valid = $modelTipo->validate();
            $valid = Model::validateMultiple($modelsOpcion) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelTipo->save(false)) {
                        if (! empty($deletedIDs)) {
                            Address::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelsOpcion as $modelOpcion) {
                            $modelOpcion->tipo_id = $modelTipo->id;
                            if (! ($flag = $modelOpcion->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $modelTipo->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('update', [
            'modelTipo' => $modelTipo,
            'modelsOpcion' => (empty($modelsOpcion)) ? [new Opcion] : $modelsOpcion
        ]);
    }

    /**
     * Deletes an existing Tipo model.
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
     * Finds the Tipo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tipo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tipo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
