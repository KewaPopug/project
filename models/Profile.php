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
 * @property string|null $position
 * @property int|null $number
 *
 * @property \app\modules\adminPanel\models\User $user1
 * @property User $user
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
            [['user_id', 'number'], 'integer'],
            [['first_name', 'second_name'], 'string', 'max' => 20],
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
}
