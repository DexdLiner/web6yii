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

/**
 * This is the model class for table "{{%users}}".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 * @property string $auth_key
 * @property string $password_reset_token
 *
 * @property Comments[] $comments
 * @property Posts[] $posts
 */
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

    public static function findByEmail($email)
    {
        return self::findOne(['email' => $email]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password', 'email', 'created_at', 'updated_at', 'auth_key'], 'required'],
            [['status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['username', 'auth_key', 'password_reset_token'], 'string', 'max' => 32],
            [['password'], 'string', 'max' => 64],
            [['email'], 'string', 'max' => 255],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'auth_key' => 'Auth Key',
            'password_reset_token' => 'Password Reset Token',
        ];
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


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comments::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Posts::className(), ['user_id' => 'id']);
    }

}