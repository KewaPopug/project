<?php

namespace app\modules\adminPanel\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * User represents the model behind the search form about `app\modules\adminPanel\models\User`.
 */
class User extends Model
{
    public $id;
    public $username;
    public $email;
    public $status;
    public $profile;
    public $second_name;
    public $first_name;
    public $position;
    public $department_name;
    public $middle_name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status',], 'integer'],
            [['username', 'position', 'second_name', 'middle_name', 'department_name', 'first_name', 'email'], 'safe'],
        ];
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
        /* @var $query \yii\db\ActiveQuery */
        $class = Yii::$app->getUser()->identityClass ? : 'app\modules\adminPanel\models\User';
        $query = $class::find();

        $query->joinWith(['profile', 'profile.department']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['second_name'] = [
            'asc' => ['profile.second_name' => SORT_ASC],
            'desc' => ['profile.second_name' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['middle_name'] = [
            'asc' => ['profile.middle_name' => SORT_ASC],
            'desc' => ['profile.middle_name' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['first_name'] = [
            'asc' => ['profile.first_name' => SORT_ASC],
            'desc' => ['profile.first_name' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['position'] = [
            'asc' => ['profile.position' => SORT_ASC],
            'desc' => ['profile.position' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['department_name'] = [
            'asc' => ['department.department_name' => SORT_ASC],
            'desc' => ['department.department_name' => SORT_DESC],
        ];

        $this->load($params);
        if (!$this->validate()) {
            $query->where('1=0');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'department_name' => $this->department_name,
//            'profile.second_name' => $this->second_name,
//            'profile.first_name' => $this->first_name,
//            'profile.position' => $this->position,

        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'profile.second_name', $this->second_name])
            ->andFilterWhere(['like', 'profile.middle_name', $this->middle_name])
            ->andFilterWhere(['like', 'profile.position', $this->position])
            ->andFilterWhere(['like', 'profile.first_name', $this->first_name])
            ->andFilterWhere(['like', 'department.department_name', $this->department_name]);

        return $dataProvider;
    }
}
