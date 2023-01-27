<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "collection_type".
 *
 * @property int $id
 * @property string|null $name
 *
 * @property CollectionItem[] $collectionItems
 */
class CollectionType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'collection_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 60],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[CollectionItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCollectionItem()
    {
        return $this->hasMany(CollectionItem::class, ['collection_type_id' => 'id']);
    }
}
