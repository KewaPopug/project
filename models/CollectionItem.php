<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "collection_item".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $collection
 * @property string|null $action
 * @property int|null $collection_type_id
 *
 * @property CollectionType $collectionType
 * @property User $user
 */
class CollectionItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'collection_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'collection_type_id'], 'integer'],
            [['action'], 'string', 'max' => 255],
            [['collection'], 'safe'],
            [['collection_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => CollectionType::class, 'targetAttribute' => ['collection_type_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'collection' => 'Collection',
            'collection_type_id' => 'Collection Type ID',
        ];
    }

    /**
     * Gets query for [[CollectionType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCollectionType()
    {
        return $this->hasOne(CollectionType::class, ['id' => 'collection_type_id']);
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
