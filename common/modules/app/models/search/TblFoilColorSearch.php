<?php

namespace common\modules\app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\app\models\TblFoilColor;

/**
 * TblFoilColorSearch represents the model behind the search form of `common\modules\app\models\TblFoilColor`.
 */
class TblFoilColorSearch extends TblFoilColor
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['foil_color_id', 'foil_color_name', 'foil_color_code', 'foil_color_description'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = TblFoilColor::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere(['like', 'foil_color_id', $this->foil_color_id])
            ->andFilterWhere(['like', 'foil_color_name', $this->foil_color_name])
            ->andFilterWhere(['like', 'foil_color_code', $this->foil_color_code])
            ->andFilterWhere(['like', 'foil_color_description', $this->foil_color_description]);

        return $dataProvider;
    }
}
