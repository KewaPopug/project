<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "item".
 *
 * @property int $id
 * @property int|null $category_id
 * @property int|null $user_id
 * @property string|null $status
 * @property string|null $name_item
 * @property string|null $number
 * @property int|null $cabinet_id
 *
 * @property Cabinet $cabinet
 * @property Category $category
 * @property User1 $user
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
            [['category_id', 'user_id', 'cabinet_id'], 'integer'],
            [['cabinet_id', 'number'], 'required'],
            [['status'], 'string', 'max' => 20],
            [['name_item', 'number'], 'string', 'max' => 30],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User1::class, 'targetAttribute' => ['user_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['cabinet_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cabinet::class, 'targetAttribute' => ['cabinet_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category.category',
            'user.profile.first_name',
//            'category_id' => 'Category ID',
//            'user_id' => 'User ID',
            'status' => 'Status',
            'name_item' => 'Name Item',
            'number' => 'Number',
            'cabinet.cabinet',
            'cabinet.corps',
//            'cabinet_id' => 'Cabinet ID',
        ];
    }

    /**
     * Gets query for [[Cabinet]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCabinet()
    {
        return $this->hasOne(Cabinet::class, ['id' => 'cabinet_id']);
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
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function beforeSave($insert)
    {
        $this->user_id = \Yii::$app->user->id;
        return $insert;
    }
}
