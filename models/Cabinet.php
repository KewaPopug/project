<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cabinet".
 *
 * @property int $id
 * @property int|null $cabinet
 * @property int|null $corps_id
 *
 * @property Corps $corps
 * @property Item[] $items
 */
class Cabinet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cabinet';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cabinet', 'corps_id'], 'integer'],
            [['corps_id'], 'exist', 'skipOnError' => true, 'targetClass' => Corps::class, 'targetAttribute' => ['corps_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cabinet' => 'Cabinet',
            'corps_id' => 'Corps ID',
        ];
    }

    /**
     * Gets query for [[Corps]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCorps()
    {
        return $this->hasOne(Corps::class, ['id' => 'corps_id']);
    }

    /**
     * Gets query for [[Items]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(Item::class, ['cabinet_id' => 'id']);
    }
}
