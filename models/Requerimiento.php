<?php

namespace app\models;
use Yii;
use app\models\Proceso;

/**
 * This is the model class for table "requerimiento".
 *
 * @property integer $id
 * @property integer $proceso_flujo_id
 * @property string $re_nombre
 * @property string $re_descripcion
 * @property string $re_estado
 *
 * @property Documentodigital[] $documentodigitals
 * @property ProcesoFlujo $procesoFlujo
 */
class Requerimiento extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'requerimiento';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['re_nombre'], 'required'],
            [['proceso_flujo_id'], 'integer'],
            [['re_descripcion'], 'string'],
            [['re_nombre'], 'string', 'max' => 50],
            [['re_estado'], 'string', 'max' => 25],
            [['re_obligatorio'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'proceso_flujo_id' => 'Proceso Flujo ID',
            're_nombre' => 'Nombre',
            're_descripcion' => 'Descripción',
            're_estado' => 'Estado',
            're_obligatorio' => 'Obligatorio',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocumentodigitals()
    {
        return $this->hasMany(Documentodigital::className(), ['requerimiento_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcesoFlujo()
    {
        return $this->hasOne(ProcesoFlujo::className(), ['id' => 'proceso_flujo_id']);
    }
    public function getDirectorio($id){
        $documento = Proceso::find()->where(['id'=>$id])->one();
        return $proceso->pr_directorio;
    }
}
