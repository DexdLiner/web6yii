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

    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['email','validateEmail'],
            ['password','validatePasswordAndPasswordConfirm']
            // password is validated by validatePassword()

        ];
    }

    public function SignUp()
    {
        $user = Userdb::findByUsername($this->username);

        return false;
    }
}