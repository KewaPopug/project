<?php

namespace app\modules\adminPanel\models;

use app\models\Profile;
use Yii;
use mdm\admin\models\User as Users;
use yii\db\ActiveQuery;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 *
 * @property Profile[] $profile
 */
class User extends Users
{
    /**
     * Gets query for [[Profile]].
     *
     * @return ActiveQuery
     */
    public function getProfile(): ActiveQuery
    {
        return $this->hasOne(Profile::class, ['user_id' => 'id']);
    }
}
