<?php

namespace common\modules\app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\app\models\TblFold;

/**
 * TblFoldSearch represents the model behind the search form of `common\modules\app\models\TblFold`.
 */
class TblFoldSearch extends TblFold
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fold_id', 'fold_name', 'fold_description'], 'safe'],
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
        $query = TblFold::find();

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
        $query->andFilterWhere(['like', 'fold_id', $this->fold_id])
            ->andFilterWhere(['like', 'fold_name', $this->fold_name])
            ->andFilterWhere(['like', 'fold_description', $this->fold_description]);

        return $dataProvider;
    }
}
