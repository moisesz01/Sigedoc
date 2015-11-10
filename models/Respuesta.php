<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "respuesta".
 *
 * @property integer $idrespuesta
 * @property integer $campo_id
 * @property string $re_respuesta
 * @property integer $documento_iddocumento
 *
 * @property Campo $campo
 * @property Documento $documentoIddocumento
 */
class Respuesta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'respuesta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['campo_id', 're_respuesta', 'documento_iddocumento'], 'required'],
            [['campo_id', 'documento_iddocumento'], 'integer'],
            [['re_respuesta'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idrespuesta' => 'Idrespuesta',
            'campo_id' => 'Campo ID',
            're_respuesta' => 'Re Respuesta',
            'documento_iddocumento' => 'Documento Iddocumento',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampo()
    {
        return $this->hasOne(Campo::className(), ['id' => 'campo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocumentoIddocumento()
    {
        return $this->hasOne(Documento::className(), ['iddocumento' => 'documento_iddocumento']);
    }
}
