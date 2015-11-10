<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "proceso".
 *
 * @property integer $id
 * @property string $pr_referencia
 * @property string $pr_nombre
 * @property string $pr_descripcion
 * @property string $pr_aprobacion
 * @property string $pr_directorio
 *
 * @property Campo[] $campos
 * @property Documento[] $documentos
 * @property ProcesoFlujo[] $procesoFlujos
 * @property UsuarioProceso[] $usuarioProcesos
 */
class Proceso extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'proceso';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pr_referencia', 'pr_nombre', 'pr_aprobacion', 'pr_directorio'], 'required'],
            [['pr_descripcion', 'pr_directorio'], 'string'],
            [['pr_referencia'], 'string', 'max' => 25],
            [['pr_nombre'], 'string', 'max' => 50],
            [['pr_aprobacion'], 'string', 'max' => 1],
            [['pr_referencia'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pr_referencia' => 'Pr Referencia',
            'pr_nombre' => 'Pr Nombre',
            'pr_descripcion' => 'Pr Descripcion',
            'pr_aprobacion' => 'Pr Aprobacion',
            'pr_directorio' => 'Pr Directorio',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampos()
    {
        return $this->hasMany(Campo::className(), ['proceso_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocumentos()
    {
        return $this->hasMany(Documento::className(), ['proceso_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcesoFlujos()
    {
        return $this->hasMany(ProcesoFlujo::className(), ['proceso_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioProcesos()
    {
        return $this->hasMany(UsuarioProceso::className(), ['proceso_id' => 'id']);
    }
}
