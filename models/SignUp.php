<?php
/**
 * Created by PhpStorm.
 * User: Grudik
 * Date: 18.02.2019
 * Time: 21:10
 */

namespace app\models;


use yii\base\Model;
use app\models\Userdb;

class SignUp extends Model
{
    public $username;
    public $password;
    public $confirmPassword;
    public $email;

    public function SignUp()
    {
        Userdb::findByUsername($this->username);
    }
}