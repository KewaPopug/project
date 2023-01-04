<?php

namespace app\models;

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

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password_hash' => 'password_hash',
            'password_reset_token' => 'password_reset_token',
            'email' => 'email',
            'auth_key' => 'auth_key',
            'status' => 'status',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at',
            'password' => 'password',
            'profile.second_name',
            'profile.middle_name',
            'profile.position',
            'profile.first_name',
        ];
    }

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
