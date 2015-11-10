<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "campo".
 *
 * @property integer $id
 * @property integer $tipo_id
 * @property integer $proceso_id
 * @property string $ca_nombre
 * @property string $ca_descripcion
 * @property string $ca_obligatorio
 * @property string $ca_estado
 * @property string $ca_multiopc
 * @property string $ca_clave
 *
 * @property Proceso $proceso
 * @property Tipo $tipo
 * @property Respuesta[] $respuestas
 */
class Campo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'campo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tipo_id', 'proceso_id', 'ca_nombre', 'ca_obligatorio', 'ca_multiopc'], 'required'],
            [['tipo_id', 'proceso_id'], 'integer'],
            [['ca_descripcion'], 'string'],
            [['ca_nombre'], 'string', 'max' => 50],
            [['ca_obligatorio', 'ca_estado', 'ca_multiopc', 'ca_clave'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tipo_id' => 'Tipo ID',
            'proceso_id' => 'Proceso ID',
            'ca_nombre' => 'Ca Nombre',
            'ca_descripcion' => 'Ca Descripcion',
            'ca_obligatorio' => 'Ca Obligatorio',
            'ca_estado' => 'Ca Estado',
            'ca_multiopc' => 'Ca Multiopc',
            'ca_clave' => 'Ca Clave',
        ];
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
    public function getTipo()
    {
        return $this->hasOne(Tipo::className(), ['id' => 'tipo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRespuestas()
    {
        return $this->hasMany(Respuesta::className(), ['campo_id' => 'id']);
    }
}
