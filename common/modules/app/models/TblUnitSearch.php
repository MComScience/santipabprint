<?php

namespace common\modules\app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\app\models\TblUnit;

/**
 * TblUnitSearch represents the model behind the search form of `common\modules\app\models\TblUnit`.
 */
class TblUnitSearch extends TblUnit
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['unit_id'], 'integer'],
            [['unit_name'], 'safe'],
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
        $query = TblUnit::find();

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
            'unit_id' => $this->unit_id,
        ]);

        $query->andFilterWhere(['like', 'unit_name', $this->unit_name]);

        return $dataProvider;
    }
}
