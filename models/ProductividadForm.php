<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class ProductividadForm extends Model
{
    public $idproceso;
    public $fechaini;
    public $fechafin;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['fechaini', 'fechafin'], 'safe'],
            [['idproceso', 'fechaini','fechafin'], 'required'],
            [['idproceso'], 'integer'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'idproceso' => 'Proceso',
            'fechaini' =>'Fecha Inicial',
            'fechafin' => 'Fecha Final'
        ];
    }
}
