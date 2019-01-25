<?php

namespace common\modules\app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\app\models\TblBookBinding;

/**
 * TblBookBindingSearch represents the model behind the search form of `common\modules\app\models\TblBookBinding`.
 */
class TblBookBindingSearch extends TblBookBinding
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['book_binding_id', 'book_binding_name', 'book_binding_description'], 'safe'],
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
        $query = TblBookBinding::find();

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
        $query->andFilterWhere(['like', 'book_binding_id', $this->book_binding_id])
            ->andFilterWhere(['like', 'book_binding_name', $this->book_binding_name])
            ->andFilterWhere(['like', 'book_binding_description', $this->book_binding_description]);

        return $dataProvider;
    }
}
