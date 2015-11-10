<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Buzondocumento;

/**
 * BuzondocumentoSearch represents the model behind the search form about `app\models\Buzondocumento`.
 */
class BuzondocumentoSearch extends Buzondocumento
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idbuzondocumento', 'bd_userorigen', 'bd_userdestino', 'documento_iddocumento'], 'integer'],
            [['bd_fechaentrada', 'bd_fechasalida', 'bd_estado'], 'safe'],
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
        $query = Buzondocumento::find();

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
            'idbuzondocumento' => $this->idbuzondocumento,
            'bd_fechaentrada' => $this->bd_fechaentrada,
            'bd_fechasalida' => $this->bd_fechasalida,
            'bd_userorigen' => $this->bd_userorigen,
            'bd_userdestino' => $this->bd_userdestino,
            'documento_iddocumento' => $this->documento_iddocumento,
        ]);

        $query->andFilterWhere(['like', 'bd_estado', $this->bd_estado]);

        return $dataProvider;
    }
}
