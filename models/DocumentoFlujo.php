<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "documento_flujo".
 *
 * @property integer $iddocumento_actividad
 * @property integer $proceso_flujo_id
 * @property string $do_fechaini
 * @property string $do_fecha_fin
 * @property string $do_respuesta
 * @property integer $usuario_idusuario
 * @property integer $documento_iddocumento
 * @property string $do_estado
 *
 * @property Documento $documentoIddocumento
 * @property ProcesoFlujo $procesoFlujo
 * @property User $usuarioIdusuario
 * @property Documentodigital[] $documentodigitals
 */
class DocumentoFlujo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'documento_flujo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['proceso_flujo_id', 'usuario_idusuario', 'documento_iddocumento'], 'required'],
            [['proceso_flujo_id', 'usuario_idusuario', 'documento_iddocumento'], 'integer'],
            [['do_fechaini', 'do_fecha_fin'], 'safe'],
            [['do_respuesta'], 'string'],
            [['do_estado'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iddocumento_actividad' => 'Iddocumento Actividad',
            'proceso_flujo_id' => 'Proceso Flujo ID',
            'do_fechaini' => 'Do Fechaini',
            'do_fecha_fin' => 'Do Fecha Fin',
            'do_respuesta' => 'Do Respuesta',
            'usuario_idusuario' => 'Usuario Idusuario',
            'documento_iddocumento' => 'Documento Iddocumento',
            'do_estado' => 'Do Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocumentoIddocumento()
    {
        return $this->hasOne(Documento::className(), ['iddocumento' => 'documento_iddocumento']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcesoFlujo()
    {
        return $this->hasOne(ProcesoFlujo::className(), ['id' => 'proceso_flujo_id']);
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
    public function getDocumentodigitals()
    {
        return $this->hasMany(Documentodigital::className(), ['documento_flujo_iddocumento_actividad' => 'iddocumento_actividad']);
    }
}
