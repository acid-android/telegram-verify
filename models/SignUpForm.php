<?php

namespace app\models;


use yii\base\Model;

class SignUpForm extends Model
{
    public $email;
    public $first_name;
    public $last_name;
    public $telegram;
    public $password;

    public function rules()
    {
        return [
            ['first_name', 'trim'],
            ['first_name', 'required'],
            ['first_name', 'string'],
            ['last_name', 'trim'],
            ['last_name', 'required'],
            ['last_name', 'string'],
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string'],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Этот e-mail уже используется.'],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['telegram', 'trim'],
            ['telegram', 'required'],
            ['telegram', 'string']
        ];
    }

    public function signup()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = new User();
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->email = $this->email;
        $user->telegram = $this->telegram;
        $user->tfv_state = User::TFA_OFF;
        $user->setPassword($this->password);
        $result = $user->save();

        $userTelegramTFA = new TelegramTfa();
        $userTelegramTFA->user_id = $user->id;
        $userTelegramTFA->save();

        $userGoogleTFA = new GoogleTfa();
        $userGoogleTFA->user_id = $user->id;
        $userGoogleTFA->save();

        return $result;
    }
}