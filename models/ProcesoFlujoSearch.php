<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProcesoFlujo;

/**
 * ProcesoFlujoSearch represents the model behind the search form about `app\models\ProcesoFlujo`.
 */
class ProcesoFlujoSearch extends ProcesoFlujo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['pf_orden'], 'number'],
            [['usuario_idusuario', 'actividad_idactividad', 'proceso_id', 'flujo_idflujo'],'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ProcesoFlujo::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->joinWith(['proceso']);
        $query->joinWith('actividadIdactividad');
        $query->joinWith('flujoIdflujo');
        $query->joinWith('usuarioIdusuario');

        $query->andFilterWhere([
            'id' => $this->id,
            /*'usuario_idusuario' => $this->usuario_idusuario,
            'actividad_idactividad' => $this->actividad_idactividad,
            'proceso_id' => $this->proceso_id,
            'flujo_idflujo' => $this->flujo_idflujo,*/
            'pf_orden' => $this->pf_orden,
        ]);
        $query->andFilterWhere(['like','proceso.pr_nombre',$this->proceso_id])
        ->andFilterWhere(['like','flujo.fl_nombre',$this->flujo_idflujo])
        ->andFilterWhere(['like','user.username',$this->usuario_idusuario])
        ->andFilterWhere(['like','actividad.ac_nombre',$this->actividad_idactividad]);

        return $dataProvider;
    }
}
