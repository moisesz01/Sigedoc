<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "opcion".
 *
 * @property integer $id
 * @property integer $tipo_id
 * @property string $op_nombre
 *
 * @property Tipo $tipo
 */
class Opcion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'opcion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['op_nombre'], 'required'],
            [['tipo_id'], 'integer'],
            [['op_nombre'], 'string', 'max' => 25]
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
            'op_nombre' => 'Nombre',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipo()
    {
        return $this->hasOne(Tipo::className(), ['id' => 'tipo_id']);
    }
}
