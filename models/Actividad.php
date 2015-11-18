<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "actividad".
 *
 * @property integer $idactividad
 * @property string $ac_nombre
 * @property string $ac_descripcion
 *
 * @property ProcesoFlujo[] $procesoFlujos
 */
class Actividad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'actividad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ac_nombre'], 'required'],
            [['ac_descripcion'], 'string'],
            [['ac_nombre'], 'string', 'max' => 25]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idactividad' => 'Identificador',
            'ac_nombre' => 'Nombre',
            'ac_descripcion' => 'Descripción',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcesoFlujos()
    {
        return $this->hasMany(ProcesoFlujo::className(), ['actividad_idactividad' => 'idactividad']);
    }
}
