<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Proceso;

/**
 * ProcesoSearch represents the model behind the search form about `app\models\Proceso`.
 */
class ProcesoSearch extends Proceso
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['pr_referencia', 'pr_nombre', 'pr_descripcion', 'pr_aprobacion', 'pr_directorio'], 'safe'],
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
        $query = Proceso::find();

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
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'pr_referencia', $this->pr_referencia])
            ->andFilterWhere(['like', 'pr_nombre', $this->pr_nombre])
            ->andFilterWhere(['like', 'pr_descripcion', $this->pr_descripcion])
            ->andFilterWhere(['like', 'pr_aprobacion', $this->pr_aprobacion])
            ->andFilterWhere(['like', 'pr_directorio', $this->pr_directorio]);

        return $dataProvider;
    }
}
