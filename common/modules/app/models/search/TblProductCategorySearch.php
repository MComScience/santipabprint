<?php

namespace common\modules\app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\app\models\TblProductCategory;

/**
 * TblProductCategorySearch represents the model behind the search form of `common\modules\app\models\TblProductCategory`.
 */
class TblProductCategorySearch extends TblProductCategory
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_category_id', 'product_category_name'], 'safe'],
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
        $query = TblProductCategory::find();

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
        $query->andFilterWhere(['like', 'product_category_id', $this->product_category_id])
            ->andFilterWhere(['like', 'product_category_name', $this->product_category_name]);

        return $dataProvider;
    }
}
