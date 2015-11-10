<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "buzondocumento".
 *
 * @property integer $idbuzondocumento
 * @property string $bd_fechaentrada
 * @property string $bd_fechasalida
 * @property string $bd_estado
 * @property integer $bd_userorigen
 * @property integer $bd_userdestino
 * @property integer $documento_iddocumento
 *
 * @property Documento $documentoIddocumento
 * @property User $bdUserorigen
 * @property User $bdUserdestino
 * @property Observacion[] $observacions
 */
class Buzondocumento extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'buzondocumento';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bd_fechaentrada', 'bd_fechasalida'], 'safe'],
            [['bd_estado', 'bd_userorigen', 'bd_userdestino', 'documento_iddocumento'], 'required'],
            [['bd_userorigen', 'bd_userdestino', 'documento_iddocumento'], 'integer'],
            [['bd_estado'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idbuzondocumento' => 'Idbuzondocumento',
            'bd_fechaentrada' => 'Bd Fechaentrada',
            'bd_fechasalida' => 'Bd Fechasalida',
            'bd_estado' => 'Bd Estado',
            'bd_userorigen' => 'Bd Userorigen',
            'bd_userdestino' => 'Bd Userdestino',
            'documento_iddocumento' => 'Documento Iddocumento',
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
    public function getBdUserorigen()
    {
        return $this->hasOne(User::className(), ['id' => 'bd_userorigen']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBdUserdestino()
    {
        return $this->hasOne(User::className(), ['id' => 'bd_userdestino']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObservacions()
    {
        return $this->hasMany(Observacion::className(), ['buzondocumento_idbuzondocumento' => 'idbuzondocumento']);
    }
}
