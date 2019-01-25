<?php

namespace common\modules\app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\app\models\TblDiecut;

/**
 * TblDiecutSearch represents the model behind the search form of `common\modules\app\models\TblDiecut`.
 */
class TblDiecutSearch extends TblDiecut
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['diecut_id', 'diecut_group_id', 'diecut_name', 'diecut_description'], 'safe'],
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
        $query = TblDiecut::find();

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
        $query->andFilterWhere(['like', 'diecut_id', $this->diecut_id])
            ->andFilterWhere(['like', 'diecut_group_id', $this->diecut_group_id])
            ->andFilterWhere(['like', 'diecut_name', $this->diecut_name])
            ->andFilterWhere(['like', 'diecut_description', $this->diecut_description]);

        return $dataProvider;
    }
}
