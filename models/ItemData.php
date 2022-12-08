<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "item_data".
 *
 * @property string|null $username
 * @property string|null $name_item
 * @property string $corps
 * @property string $cabinet
 * @property string $category
 * @property string|null $number
 * @property string|null $status
 */
class ItemData extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'item_data';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['corps', 'cabinet', 'category'], 'required'],
            [['username'], 'string', 'max' => 255],
            [['name_item', 'number'], 'string', 'max' => 30],
            [['corps', 'cabinet', 'category'], 'string', 'max' => 10],
            [['status'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Username',
            'name_item' => 'Name Item',
            'corps' => 'Corps',
            'cabinet' => 'Cabinet',
            'category' => 'Category',
            'number' => 'Number',
            'status' => 'Status',
        ];
    }
}
