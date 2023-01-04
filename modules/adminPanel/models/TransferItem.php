<?php

namespace app\modules\adminPanel\models;

use app\models\Cabinet;
use app\models\Category;
use app\models\Profile;
use app\models\User;
use yii\db\ActiveQuery;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "item".
 *
 * @property int $id
 * @property int|null $category_id
 * @property int|null $user_id
 * @property string|null $status
 * @property string|null $name_item
 * @property string|null $number_item
 * @property int|null $cabinet_id
 *
 * @property Cabinet $cabinet
 * @property Category $category
 * @property User $user
 */
class TransferItem extends ActiveRecord
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
            [['cabinet_id', 'number_item'], 'required'],
            [['status'], 'string', 'max' => 20],
            [['name_item', 'number_item'], 'string', 'max' => 30],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'number_item' => 'Number',
            'cabinet.cabinet',
            'cabinet.corps',
//            'cabinet_id' => 'Cabinet ID',
        ];
    }

    public function transfer($id)
    {

    }
}