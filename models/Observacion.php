<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "observacion".
 *
 * @property integer $idobservacion
 * @property integer $buzondocumento_idbuzondocumento
 * @property string $ob_observacion
 * @property string $ob_fecha
 *
 * @property Buzondocumento $buzondocumentoIdbuzondocumento
 */
class Observacion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'observacion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['buzondocumento_idbuzondocumento', 'ob_observacion'], 'required'],
            [['buzondocumento_idbuzondocumento'], 'integer'],
            [['ob_observacion'], 'string'],
            [['ob_fecha'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idobservacion' => 'Idobservacion',
            'buzondocumento_idbuzondocumento' => 'Buzondocumento Idbuzondocumento',
            'ob_observacion' => 'Observación',
            'ob_fecha' => 'Ob Fecha',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuzondocumentoIdbuzondocumento()
    {
        return $this->hasOne(Buzondocumento::className(), ['idbuzondocumento' => 'buzondocumento_idbuzondocumento']);
    }
}
