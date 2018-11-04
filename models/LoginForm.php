<?php
namespace app\models;
use app\utilities\Verification\Verification;
use yii\base\Model;
/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $_user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $email;
    public $password;
    private $_user = false;
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            [['email'], 'email'], 
            ['password', 'string'],
        ];
    }

    public function authorize(){

        $this->_user = User::find()->where(['email' => $this->email])->one();
        if($this->_user){
            if($this->_user->validatePassword($this->password)){
                if($this->_user->tfv_state == User::TFA_ON) {
                    return Verification::authorize($this->_user);
                } else {
                    return \Yii::$app->user->login($this->_user);
                }
            }
        }
        return false;
    }

    public function getUserHash(){
        return $this->_user->getHash();
    }

    public function getUser(){
        return $this->_user;
    }
}