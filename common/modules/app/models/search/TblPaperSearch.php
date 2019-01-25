<?php

namespace common\modules\app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\app\models\TblPaper;

/**
 * TblPaperSearch represents the model behind the search form of `common\modules\app\models\TblPaper`.
 */
class TblPaperSearch extends TblPaper
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['paper_id', 'paper_type_id', 'paper_name', 'paper_description'], 'safe'],
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
        $query = TblPaper::find();

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
        $query->andFilterWhere(['like', 'paper_id', $this->paper_id])
            ->andFilterWhere(['like', 'paper_type_id', $this->paper_type_id])
            ->andFilterWhere(['like', 'paper_name', $this->paper_name])
            ->andFilterWhere(['like', 'paper_description', $this->paper_description]);

        return $dataProvider;
    }
}
