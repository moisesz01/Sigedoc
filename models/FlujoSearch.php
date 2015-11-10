<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Flujo;

/**
 * FlujoSearch represents the model behind the search form about `app\models\Flujo`.
 */
class FlujoSearch extends Flujo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idflujo'], 'integer'],
            [['fl_nombre', 'fl_descripcion'], 'safe'],
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
        $query = Flujo::find();

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
            'idflujo' => $this->idflujo,
        ]);

        $query->andFilterWhere(['like', 'fl_nombre', $this->fl_nombre])
            ->andFilterWhere(['like', 'fl_descripcion', $this->fl_descripcion]);

        return $dataProvider;
    }
}
