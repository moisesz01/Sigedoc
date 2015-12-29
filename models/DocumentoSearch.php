<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Documento;

/**
 * DocumentoSearch represents the model behind the search form about `app\models\Documento`.
 */
class DocumentoSearch extends Documento
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['iddocumento'], 'integer'],
            [['do_referencia', 'do_nombre', 'do_descripcion','proceso_id'], 'safe'],
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
        $query = Documento::find();

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
            'iddocumento' => $this->iddocumento,
        ]);
        $query->joinWith('proceso');

        $query->andFilterWhere(['like', 'do_referencia', $this->do_referencia])
            ->andFilterWhere(['like', 'do_nombre', $this->do_nombre])
            ->andFilterWhere(['like','proceso.pr_nombre',$this->proceso_id])
            ->andFilterWhere(['like', 'do_descripcion', $this->do_descripcion]);

        return $dataProvider;
    }
}
