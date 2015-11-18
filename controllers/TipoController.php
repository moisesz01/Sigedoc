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
use yii\helpers\ArrayHelper;

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
        $opciones = Opcion::find()->where(['tipo_id'=>$id])->all();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'opciones'=>$opciones,
        ]);
    }

    /**
     * Creates a new Tipo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tipo;
        $modelsOpcion = [new Opcion];
        if ($model->load(Yii::$app->request->post())) {

            $modelsOpcion = Model::createMultiple(Opcion::classname());
            Model::loadMultiple($modelsOpcion, Yii::$app->request->post());

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsOpcion),
                    ActiveForm::validate($model)
                );
            }

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsOpcion) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        foreach ($modelsOpcion as $modelOpcion) {
                            $modelOpcion->tipo_id = $model->id;
                            if (! ($flag = $modelOpcion->save(false))) {
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
        $model = $this->findModel($id);
        $modelsOpcion = $model->opcions;

        if ($model->load(Yii::$app->request->post())) {

            $oldIDs = ArrayHelper::map($modelsOpcion, 'id', 'id');
            $modelsOpcion = Model::createMultiple(Opcion::classname(), $modelsOpcion);
            Model::loadMultiple($modelsOpcion, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsOpcion, 'id', 'id')));

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsOpcion),
                    ActiveForm::validate($model)
                );
            }

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsOpcion) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (! empty($deletedIDs)) {
                            Opcion::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelsOpcion as $modelOpcion) {
                            $modelOpcion->tipo_id = $model->id;
                            if (! ($flag = $modelOpcion->save(false))) {
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

        try {
            
            Opcion::deleteAll('tipo_id = :id', [':id' => $id]);    
            $this->findModel($id)->delete();
            Yii::$app->session->setFlash('success',Yii::t('app', 'Eliminación exitosa'));
            return $this->redirect(['index']);
            
        } catch (yii\db\IntegrityException $e) {
            
            Yii::$app->session->setFlash('danger',Yii::t('app', 'Registro no se puede borrar, hay una relación asociada a el'));
            return $this->redirect(['index']);
            
        }
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
