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
use yii;

class SignUp extends Model
{
    //todo:: make validtor chech uniq email and render uniq password_reset_token
    public $username;
    public $password;
    public $confirmPassword;
    public $email;

    public function rules()
    {
        return [
            // username and password are both required
            [['password', 'confirmPassword', 'email'], 'required'],
//            ['email', 'unique'],
//            ['username', 'unique'],//todo: repeat on relations
            // rememberMe must be a boolean value
            ['username', 'match', 'pattern' => '@^[a-z]+$@', 'message' => 'Invalid user name'],
            ['email', 'validateEmail', 'message' => 'Invalid user name'],
            ['password', 'validatePasswordAndPasswordConfirm']
            // password is validated by validatePassword()

        ];
    }

    public function validatePasswordAndPasswordConfirm($password, $params)
    {
//        var_dump($this);
//        exit();
        if ($this->password !== $this->confirmPassword) {
//            echo 123;
            $this->addError($password, 'Password does not match');
            return false;
        } else {
            return true;
        }
    }

    public function validateEmail($email, $params)
    {
        $temp = Userdb::findOne(['email' => $this->email]);

        if (!empty($temp)) {
            $this->addError($email, 'such email does exist');
            return false;
        }
//        echo '<pre>';
//        print_r($temp);
//        echo '</pre>';
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL) &&
            preg_match('#^[a-z][a-z0-9\-_\.]+\@gmail\.com$#i', $this->email)
        ) {
            return true;
        } else {
            $this->addError($email, 'Email does not match');
            return false;
        }
    }

    public function SignUp()
    {
        $status = $this->validate();

        $user = Userdb::findByUsername($this->username);

        if (!empty($user)) {
            $this->addError('username', 'User already exists');
            return false;
        } else if ($status === true) {

            $user = new Userdb();

            $user->setAttributes([
                'username' => $this->username,
                'password' => $this->password,
                'email' => $this->email,
                'status' => Userdb::USER_STATUS_REGISTERED,
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s'),
                'auth_key' => 'this will be ',//todo:create
                'password_reset_token' => md5(uniqid(rand(), true))//todo: create

            ], true);

            if ($user->save()) {
                return true;
            } else {
                return false;
            }
        }

    }
}