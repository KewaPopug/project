<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "profile".
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $first_name
 * @property string|null $second_name
 * @property string|null $middle_name
 * @property string|null $position
 * @property string|null $department_id
 * @property int|null $number
 *
 * @property \app\modules\adminPanel\models\User $user1
 * @property User $user
 * @property History $history
 */

class Profile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
//        $class = new $this;
        return [
            [['user_id'], 'required'],
            [['user_id', 'number', 'department_id'], 'integer'],
            [['first_name', 'second_name', 'middle_name'], 'string', 'max' => 20],
//            [['first_name'], 'unique', 'targetClass' => $class, 'message' => 'This username has already been taken.'],
            [['position'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\modules\adminPanel\models\User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'first_name' => 'First Name',
            'second_name' => 'Second Name',
            'position' => 'Position',
            'number' => 'Number',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Gets query for [[Item]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasMany(Item::class, ['user_id' => 'user_id']);
    }

    public function getDepartment()
    {
        return $this->hasOne(Department::class, ['id' => 'department_id']);
    }

    /**
     * Gets query for [[History]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHistory()
    {
        return $this->hasMany(History::class, ['user_id' => 'user_id']);
    }
}
