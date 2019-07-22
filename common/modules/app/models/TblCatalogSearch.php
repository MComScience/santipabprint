<?php

namespace common\modules\app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\app\models\TblCatalog;

/**
 * TblCatalogSearch represents the model behind the search form of `common\modules\app\models\TblCatalog`.
 */
class TblCatalogSearch extends TblCatalog
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['catalog_id', 'catalog_type_id'], 'integer'],
            [['catalog_name', 'catalog_detail', 'image_path', 'image_base_url'], 'safe'],
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
        $query = TblCatalog::find()->orderBy('catalog_id DESC');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
             'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'catalog_id' => $this->catalog_id,
            'catalog_type_id' => $this->catalog_type_id,
        ]);

        $query->andFilterWhere(['like', 'catalog_name', $this->catalog_name])
            ->andFilterWhere(['like', 'catalog_detail', $this->catalog_detail])
            ->andFilterWhere(['like', 'image_path', $this->image_path])
            ->andFilterWhere(['like', 'image_base_url', $this->image_base_url]);

        return $dataProvider;
    }
}
