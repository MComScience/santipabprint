<?php

namespace common\modules\settings\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\settings\models\TblProductType;

/**
 * TblProductTypeSearch represents the model behind the search form of `common\modules\settings\models\TblProductType`.
 */
class TblProductTypeSearch extends TblProductType
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_type_id', 'product_type_name', 'product_img_path', 'product_img_base_url', 'created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
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
        $query = TblProductType::find();

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
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'product_type_id', $this->product_type_id])
            ->andFilterWhere(['like', 'product_type_name', $this->product_type_name])
            ->andFilterWhere(['like', 'product_img_path', $this->product_img_path])
            ->andFilterWhere(['like', 'product_img_base_url', $this->product_img_base_url]);

        return $dataProvider;
    }
}
