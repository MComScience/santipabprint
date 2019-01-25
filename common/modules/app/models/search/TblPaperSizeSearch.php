<?php

namespace common\modules\app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\app\models\TblPaperSize;

/**
 * TblPaperSizeSearch represents the model behind the search form of `common\modules\app\models\TblPaperSize`.
 */
class TblPaperSizeSearch extends TblPaperSize
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['paper_size_id', 'paper_size_name', 'paper_size_description'], 'safe'],
            [['paper_size_width', 'paper_size_height', 'paper_unit_id'], 'integer'],
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
        $query = TblPaperSize::find();

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
        $query->andFilterWhere([
            'paper_size_width' => $this->paper_size_width,
            'paper_size_height' => $this->paper_size_height,
            'paper_unit_id' => $this->paper_unit_id,
        ]);

        $query->andFilterWhere(['like', 'paper_size_id', $this->paper_size_id])
            ->andFilterWhere(['like', 'paper_size_name', $this->paper_size_name])
            ->andFilterWhere(['like', 'paper_size_description', $this->paper_size_description]);

        return $dataProvider;
    }
}
