<?php

namespace common\modules\app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\app\models\TblQuotation;

/**
 * TblQuotationSearch represents the model behind the search form of `common\modules\app\models\TblQuotation`.
 */
class TblQuotationSearch extends TblQuotation
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quotation_id', 'quotation_customer_name', 'quotation_customer_address', 'quotation_customer_email', 'quotation_customer_tel', 'created_at', 'updated_at'], 'safe'],
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
        $query = TblQuotation::find()->orderBy('quotation_id DESC');

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
        /* $query->andFilterWhere([
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]); */

        $query->andFilterWhere(['like', 'quotation_id', $this->quotation_id])
            ->andFilterWhere(['like', 'quotation_customer_name', $this->quotation_customer_name])
            ->andFilterWhere(['like', 'quotation_customer_address', $this->quotation_customer_address])
            ->andFilterWhere(['like', 'quotation_customer_email', $this->quotation_customer_email])
            ->andFilterWhere(['like', 'quotation_customer_tel', $this->quotation_customer_tel])
            ->andFilterWhere(['like', 'created_at', $this->created_at]);

        return $dataProvider;
    }
}
