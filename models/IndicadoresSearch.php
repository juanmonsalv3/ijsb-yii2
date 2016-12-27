<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Indicadores;

/**
 * IndicadoresSearch represents the model behind the search form about `app\models\Indicadores`.
 */
class IndicadoresSearch extends Indicadores
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_indicador', 'id_grupo', 'id_dimension', 'periodo'], 'integer'],
            [['descripcion'], 'safe'],
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
        $query = Indicadores::find();

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
            'id_indicador' => $this->id_indicador,
            'id_grupo' => $this->id_grupo,
            'id_dimension' => $this->id_dimension,
            'periodo' => $this->periodo,
        ]);

        $query->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
