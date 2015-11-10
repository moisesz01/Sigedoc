<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "flujo".
 *
 * @property integer $idflujo
 * @property string $fl_nombre
 * @property string $fl_descripcion
 *
 * @property ProcesoFlujo[] $procesoFlujos
 */
class Flujo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'flujo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fl_nombre'], 'required'],
            [['fl_descripcion'], 'string'],
            [['fl_nombre'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idflujo' => 'Idflujo',
            'fl_nombre' => 'Fl Nombre',
            'fl_descripcion' => 'Fl Descripcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcesoFlujos()
    {
        return $this->hasMany(ProcesoFlujo::className(), ['flujo_idflujo' => 'idflujo']);
    }
}
