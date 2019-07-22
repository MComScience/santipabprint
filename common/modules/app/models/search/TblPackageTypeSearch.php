<?php

namespace common\modules\app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\app\models\TblPackageType;

/**
 * TblPackageTypeSearch represents the model behind the search form of `common\modules\app\models\TblPackageType`.
 */
class TblPackageTypeSearch extends TblPackageType
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['package_type_id'], 'integer'],
            [['package_type_name'], 'safe'],
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
        $query = TblPackageType::find();

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
            'package_type_id' => $this->package_type_id,
        ]);

        $query->andFilterWhere(['like', 'package_type_name', $this->package_type_name]);

        return $dataProvider;
    }
}
