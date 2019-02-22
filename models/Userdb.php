<?php
/**
 * Created by PhpStorm.
 * User: Grudik
 * Date: 18.02.2019
 * Time: 19:01
 */

namespace app\models;


use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class Userdb extends ActiveRecord implements \yii\web\IdentityInterface
{
    const USER_STATUS_REGISTERED = 1;
    const USER_STATUS_CONFIRMED = 10;
    const USER_STATUS_MODERATOR = 11;
    const USER_STATUS_ADMIN = 100;

    public static function tableName()
    {

        return '{{%users}}';

    }

    public static function findIdentity($id)
    {
        $user = static::findOne($id);
        if (!empty($user)) {
            return $user;
        }
        return null;

    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // auth_key == AcessToken
        $user = static::findOne(['auth_key' => $token]);
        if (!empty($user)) {
            return $user;
        }
        return null;
    }

    public static function findByUsername($username)
    {
        return self::findOne(['username' => $username]);
    }

    public function validatePassword($password)
    {
        if ($this->password == $password) {
            return true;
        }
        return false;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;

    }

}