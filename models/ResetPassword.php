<?php

namespace app\models;

use yii\db\ActiveRecord;

class ResetPassword extends ActiveRecord
{
    public function reset(){
        $user = $model->signup();
        if ($this->validate()) {
            $user =
                $user->setPassword($this->password);
            if ($user->save()) {
                return $user;
            }
        }
        return false;
    }
}