<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "history".
 *
 * @property int $id
 * @property int $item_id
 * @property int|null $user_id
 * @property string|null $title
 * @property string|null $description
 * @property string|null $date
 *
 * @property Item $item
 * @property Profile $profile
 */
class History extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_id'], 'required'],
            [['item_id', 'user_id'], 'integer'],
            [['date'], 'safe'],
            [['title', 'description'], 'string', 'max' => 255],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => Item::class, 'targetAttribute' => ['item_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::class, 'targetAttribute' => ['user_id' => 'user_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'item_id' => 'Item ID',
            'user_id' => 'User ID',
            'title' => 'Title',
            'description' => 'Description',
            'date' => 'Date',
            'profile.second_name'
        ];
    }

    /**
     * Gets query for [[Item]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(Item::class, ['id' => 'item_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::class, ['user_id' => 'user_id']);
    }

    public function beforeSave($insert)
    {
        date_default_timezone_set('Etc/GMT+6');
        $this->user_id = Yii::$app->user->id;
//        $this->date = time();
        $this->date = date('y:m:d h:i:s');
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }
}
