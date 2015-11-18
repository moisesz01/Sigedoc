<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "proceso_flujo".
 *
 * @property integer $id
 * @property integer $usuario_idusuario
 * @property integer $actividad_idactividad
 * @property integer $proceso_id
 * @property integer $flujo_idflujo
 * @property string $pf_orden
 *
 * @property DocumentoFlujo[] $documentoFlujos
 * @property Actividad $actividadIdactividad
 * @property Flujo $flujoIdflujo
 * @property Proceso $proceso
 * @property User $usuarioIdusuario
 * @property Requerimiento[] $requerimientos
 */
class ProcesoFlujo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'proceso_flujo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['usuario_idusuario', 'actividad_idactividad', 'proceso_id', 'flujo_idflujo', 'pf_orden'], 'required'],
            [['usuario_idusuario', 'actividad_idactividad', 'proceso_id', 'flujo_idflujo'], 'integer'],
            [['pf_orden'], 'number'],
            [['flujo_idflujo', 'proceso_id', 'actividad_idactividad'], 'unique', 'targetAttribute' => ['flujo_idflujo', 'proceso_id', 'actividad_idactividad'], 'message' => 'The combination of Actividad Idactividad, Proceso ID and Flujo Idflujo has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            
            'actividad_idactividad' => 'Actividad',
            'proceso_id' => 'Proceso',
            'flujo_idflujo' => 'Flujo',
            'usuario_idusuario' => 'Responsable',
            'pf_orden' => 'Orden',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocumentoFlujos()
    {
        return $this->hasMany(DocumentoFlujo::className(), ['proceso_flujo_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActividadIdactividad()
    {
        return $this->hasOne(Actividad::className(), ['idactividad' => 'actividad_idactividad']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFlujoIdflujo()
    {
        return $this->hasOne(Flujo::className(), ['idflujo' => 'flujo_idflujo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProceso()
    {
        return $this->hasOne(Proceso::className(), ['id' => 'proceso_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioIdusuario()
    {
        return $this->hasOne(User::className(), ['id' => 'usuario_idusuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequerimientos()
    {
        return $this->hasMany(Requerimiento::className(), ['proceso_flujo_id' => 'id']);
    }
}
