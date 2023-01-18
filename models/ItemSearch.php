<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Item;

/**
 * ItemSearch represents the model behind the search form of `app\models\Item`.
 */
class ItemSearch extends Item
{
    public $category;
    public $cabinet;
    public $profile;
    /**
     * @var mixed|null
     */

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'user_id', 'cabinet_id'], 'integer'],
            [['status', 'name_item', 'number_item', 'active'], 'safe'],
            [['category', 'profile', 'cabinet'], 'safe'],
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
        if(\Yii::$app->user->can('admin_access')) {
            $query = Item::find();
        } else {
            $query = Item::findAllItem();
        }

        $query->joinWith(['category', 'cabinet', 'profile']);
//        $query->with(['']);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['category'] = [
            'asc' => ['category.category' => SORT_ASC],
            'desc' => ['category.category' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['profile'] = [
            'asc' => ['profile.second_name' => SORT_ASC],
            'desc' => ['profile.second_name' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['cabinet'] = [
            'asc' => ['cabinet.cabinet' => SORT_ASC],
            'desc' => ['cabinet.cabinet' => SORT_DESC],
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
            'category' => $this->category,
            'cabinet' => $this->cabinet,
            'active' => $this->active,
            'number_item' => $this->number_item,
            'category_id' => $this->category_id,
            'user_id' => $this->user_id,
            'cabinet_id' => $this->cabinet_id,
        ]);

        $query->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'active', $this->active])
            ->andFilterWhere(['like', 'name_item', $this->name_item])
            ->andFilterWhere(['like', 'number_item', $this->number_item])
            ->andFilterWhere(['like', 'category.category', $this->category])
            ->andFilterWhere(['like', 'cabinet.cabinet', $this->cabinet])
            ->andFilterWhere(['like', 'profile.second_name', $this->profile]);
        return $dataProvider;
    }
}
