<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuario_proceso".
 *
 * @property integer $idusuario_proceso
 * @property integer $usuario_idusuario
 * @property integer $proceso_id
 *
 * @property Proceso $proceso
 * @property User $usuarioIdusuario
 */
class UsuarioProceso extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usuario_proceso';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['usuario_idusuario', 'proceso_id'], 'required'],
            [['usuario_idusuario', 'proceso_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idusuario_proceso' => 'Idusuario Proceso',
            'usuario_idusuario' => 'Usuario Idusuario',
            'proceso_id' => 'Proceso ID',
        ];
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
    public function getUsuarioIdusuario()
    {
        return $this->hasOne(User::className(), ['id' => 'usuario_idusuario']);
    }
}
