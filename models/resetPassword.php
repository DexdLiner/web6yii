<?php
/**
 * Created by PhpStorm.
 * User: Grudik
 * Date: 01.03.2019
 * Time: 19:21
 */

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\Html;

class resetPassword extends Model
{

    public $email;
    public $captcha;

    public function rules()
    {
        return [
            [['email', 'captcha'], 'required'],
            ['email', 'email'],
            ['captcha', 'captcha']
        ];

    }

    public function attributeLabels()
    {
        return [
            'email' => 'Имейл',
            'captcha' => 'Введіть код з рисунка'
        ];
    }

    public function resetPassword()
    {
        if ($this->validate()) {
            $user = Userdb::findOne(['email' => $this->email]);

            if (!empty($user->email)) {

                Yii::$app->mailer->compose()
                    ->setTo($this->email)
                    ->setFrom(Yii::$app->params['adminEmail'])
                    ->setSubject('reset password')
                    ->setHtmlBody('<a href="' . Yii::$app->params['BaseUrl'] . 'site/reset-password&token=' . $user->password_reset_token . '">visit</a>')
                    ->send();

                return true;

            }
        }
        return false;
    }

}