<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "item".
 *
 * @property int $id
 * @property int|null $place_id
 * @property int|null $category_id
 * @property int|null $user_id
 * @property string|null $status
 * @property string|null $name_item
 * @property string|null $number
 *
 * @property Category $category
 * @property Place $place
 * @property User $user
 */
class Item extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['place_id', 'category_id', 'user_id'], 'integer'],
            [['status'], 'string', 'max' => 20],
            [['name_item', 'number'], 'string', 'max' => 30],
            [['place_id'], 'exist', 'skipOnError' => true, 'targetClass' => Place::class, 'targetAttribute' => ['place_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
//            'place_id' => 'Place ID',
//            'category_id' => 'Category ID',
//            'user_id' => 'User ID',
//            'id',
//            'place_id',
//            'category_id',
//            'user_id',
            'name_item',
            'number' => 'Number',
            'place.corps' => 'Corps',
            'place.cabinet' => 'Cabinet',
            'user.username' => 'User Name',
            'category.category' => 'Category',
            'name_item' => 'Name Item',

            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[Place]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlace()
    {
        return $this->hasOne(Place::class, ['id' => 'place_id']);
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
}
