<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "documento".
 *
 * @property integer $iddocumento
 * @property string $do_referencia
 * @property integer $proceso_id
 * @property string $do_nombre
 * @property string $do_descripcion
 *
 * @property Buzondocumento[] $buzondocumentos
 * @property Proceso $proceso
 * @property DocumentoFlujo[] $documentoFlujos
 * @property Respuesta[] $respuestas
 */
class Documento extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'documento';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['do_referencia', 'proceso_id', 'do_nombre'], 'required'],
            [['proceso_id'], 'integer'],
            [['do_descripcion'], 'string'],
            [['do_referencia'], 'string', 'max' => 25],
            [['do_nombre'], 'string', 'max' => 50],
            [['do_referencia'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iddocumento' => 'Identificador del documento',
            'do_referencia' => 'Referencia',
            'proceso_id' => 'Proceso',
            'do_nombre' => 'Nombre',
            'do_descripcion' => 'Descripción',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuzondocumentos()
    {
        return $this->hasMany(Buzondocumento::className(), ['documento_iddocumento' => 'iddocumento']);
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
    public function getDocumentoFlujos()
    {
        return $this->hasMany(DocumentoFlujo::className(), ['documento_iddocumento' => 'iddocumento']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRespuestas()
    {
        return $this->hasMany(Respuesta::className(), ['documento_iddocumento' => 'iddocumento']);
    }
}
