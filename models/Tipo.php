<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipo".
 *
 * @property integer $id
 * @property string $ti_tipo
 *
 * @property Campo[] $campos
 * @property Opcion[] $opcions
 */
class Tipo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tipo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ti_tipo'], 'required'],
            [['ti_tipo'], 'string', 'max' => 25]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ti_tipo' => 'Tipo de Dato',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampos()
    {
        return $this->hasMany(Campo::className(), ['tipo_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOpcions()
    {
        return $this->hasMany(Opcion::className(), ['tipo_id' => 'id']);
    }
}
