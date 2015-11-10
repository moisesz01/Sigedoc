<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "documentodigital".
 *
 * @property integer $iddocumentodigital
 * @property integer $requerimiento_id
 * @property integer $documento_flujo_iddocumento_actividad
 * @property string $dd_nombre
 * @property string $dd_ruta
 * @property string $dd_tipo
 * @property string $dd_aprobar
 * @property string $dd_url
 * @property string $dd_miniurl
 * @property string $dd_thumb_name
 * @property string $dd_comentario
 *
 * @property DocumentoFlujo $documentoFlujoIddocumentoActividad
 * @property Requerimiento $requerimiento
 */
class Documentodigital extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'documentodigital';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['requerimiento_id', 'documento_flujo_iddocumento_actividad', 'dd_nombre', 'dd_ruta', 'dd_tipo'], 'required'],
            [['requerimiento_id', 'documento_flujo_iddocumento_actividad'], 'integer'],
            [['dd_nombre', 'dd_ruta', 'dd_tipo', 'dd_url', 'dd_miniurl', 'dd_thumb_name', 'dd_comentario'], 'string'],
            [['dd_aprobar'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iddocumentodigital' => 'Iddocumentodigital',
            'requerimiento_id' => 'Requerimiento ID',
            'documento_flujo_iddocumento_actividad' => 'Documento Flujo Iddocumento Actividad',
            'dd_nombre' => 'Dd Nombre',
            'dd_ruta' => 'Dd Ruta',
            'dd_tipo' => 'Dd Tipo',
            'dd_aprobar' => 'Dd Aprobar',
            'dd_url' => 'Dd Url',
            'dd_miniurl' => 'Dd Miniurl',
            'dd_thumb_name' => 'Dd Thumb Name',
            'dd_comentario' => 'Dd Comentario',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocumentoFlujoIddocumentoActividad()
    {
        return $this->hasOne(DocumentoFlujo::className(), ['iddocumento_actividad' => 'documento_flujo_iddocumento_actividad']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequerimiento()
    {
        return $this->hasOne(Requerimiento::className(), ['id' => 'requerimiento_id']);
    }
}
