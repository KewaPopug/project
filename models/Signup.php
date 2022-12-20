<?php
namespace app\models;

use yii\base\Model;
use mdm\admin\models\form\Signup as Signups;
/**
 * Signup form
 */
class Signup extends Signups
{
    public $username;
    public $email;
    public $password;
    public $retypePassword;
}
