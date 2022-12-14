<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "corps".
 *
 * @property int $id
 * @property int|null $corps
 *
 * @property Cabinet[] $cabinets
 */
class Corps extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'corps';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['corps'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'corps' => 'Corps',
        ];
    }

    /**
     * Gets query for [[Cabinets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCabinets()
    {
        return $this->hasMany(Cabinet::class, ['corps_id' => 'id']);
    }
}
