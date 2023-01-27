<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CollectionItem;

/**
 * CollectionItemSearch represents the model behind the search form of `app\models\CollectionItem`.
 */
class CollectionItemSearch extends CollectionItem
{
    public $username;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'collection_type_id'], 'integer'],
            [['collection', 'username', 'number_item',], 'safe'],
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
        $query = CollectionItem::find();

        $query->joinWith(['user']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['username'] = [
            'asc' => ['user.username' => SORT_ASC],
            'desc' => ['user.username' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'collection_type_id' => $this->collection_type_id,
        ]);

        $query->andFilterWhere(['like', 'collection', $this->collection])
            ->andFilterWhere(['like', 'active', $this->username]);
//            ->andFilterWhere(['like', 'active', $this->number_item]);

        return $dataProvider;
    }
}
