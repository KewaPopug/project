<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\History;

/**
 * HistorySearch represents the model behind the search form of `app\models\History`.
 */
class HistorySearch extends History
{
    public $profile;
    public $item;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'item_id', 'user_id'], 'integer'],
            [['title', 'description', 'date', 'item', 'profile'], 'safe'],
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
        $query = History::find();

        // add conditions that should always apply here
        $query->joinWith(['item', 'profile']);


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['item'] = [
            'asc' => ['item.number_item' => SORT_ASC],
            'desc' => ['item.number_item' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['profile'] = [
            'asc' => ['profile.second_name' => SORT_ASC],
            'desc' => ['profile.second_name' => SORT_DESC],
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
            'item_id' => $this->item_id,
            'user_id' => $this->user_id,
            'date' => $this->date,

        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'profile.second_name', $this->profile])
            ->andFilterWhere(['like', 'item.number_item', $this->item]);

        return $dataProvider;
    }
}
