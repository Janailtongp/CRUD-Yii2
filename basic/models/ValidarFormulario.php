<?php

namespace app\models;

use Yii;
use yii\base\model;

class ValidarFormulario extends model {

    public $nome;
    public $email;

    public function rules() {
        return [
            ['nome', 'required', 'message' => 'Campo obrigatório.'],
            ['nome', 'match', 'pattern' => "/^.{3,50}$/", 'message' => 'Tamanho entre 3 e 50 caracteres.'],
            ['nome', 'match', 'pattern' => "/^[0-9a-z]+$/i", 'message' => 'Apenas letras e números.'],
            ['email', 'required', 'message' => 'Campo obrigatório.'],
            ['email', 'match', 'pattern' => "/^.{5,80}$/", 'message' => 'Tamanho entre 5 e 80 caracteres.'],
            ['email', 'email', 'message' => 'Formato de Email inválido.'],
        ];
    }

    public function attributeLabels() {
        return [
            ['nome' => 'Nome:'],
            ['email' => 'Email:'],
        ];
    }

}
