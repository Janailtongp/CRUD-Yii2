<?php

namespace app\models;

use Yii;
use yii\base\model;
use app\models\Users;

class FormRegister extends model {

    public $username;
    public $email;
    public $password;
    public $password_repeat;

    public function rules() {
        return [
            [['username', 'email', 'password', 'password_repeat'], 'required', 'message' => 'Campo obrigatório'],
            ['username', 'match', 'pattern' => "/^.{3,50}$/", 'message' => 'No mínimo 3 e no máximo 50 caracteres'],
            ['username', 'match', 'pattern' => "/^[0-9a-z]+$/i", 'message' => 'Apenas letras e números'],
            ['username', 'username_existe'],
            ['email', 'match', 'pattern' => "/^.{5,80}$/", 'message' => 'No mínimo 5 e no máximo 80 caracteres'],
            ['email', 'email', 'message' => 'Formato inválido'],
            ['email', 'email_existe'],
            ['password', 'match', 'pattern' => "/^.{8,16}$/", 'message' => 'No mínimo 6 e no máximo 16 caracteres'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Senhas não corresponem'],
        ];
    }

    public function email_existe($attribute, $params) {

        //Buscar el email en la tabla
        $table = Users::find()->where("email=:email", [":email" => $this->email]);

        //Si el email existe mostrar el error
        if ($table->count() == 1) {
            $this->addError($attribute, "Este email já está cadastrado em nosso sistema");
        }
    }

    public function username_existe($attribute, $params) {
        //Buscar el username en la tabla
        $table = Users::find()->where("username=:username", [":username" => $this->username]);

        //Si el username existe mostrar el error
        if ($table->count() == 1) {
            $this->addError($attribute, "Este usuário já existem em nosso sistema");
        }
    }

}
