<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\actividad;

/**
 * actividadSearch represents the model behind the search form about `app\models\actividad`.
 */
class actividadSearch extends actividad
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idactividad'], 'integer'],
            [['ac_nombre', 'ac_descripcion'], 'safe'],
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
        $query = actividad::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'idactividad' => $this->idactividad,
        ]);

        $query->andFilterWhere(['like', 'ac_nombre', $this->ac_nombre])
            ->andFilterWhere(['like', 'ac_descripcion', $this->ac_descripcion]);

        return $dataProvider;
    }
}
