<?php

namespace common\modules\app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\app\models\TblDiecutGroup;

/**
 * TblDiecutGroupSearch represents the model behind the search form of `common\modules\app\models\TblDiecutGroup`.
 */
class TblDiecutGroupSearch extends TblDiecutGroup
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['diecut_group_id', 'diecut_group_name'], 'safe'],
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
        $query = TblDiecutGroup::find();

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
        $query->andFilterWhere(['like', 'diecut_group_id', $this->diecut_group_id])
            ->andFilterWhere(['like', 'diecut_group_name', $this->diecut_group_name]);

        return $dataProvider;
    }
}
