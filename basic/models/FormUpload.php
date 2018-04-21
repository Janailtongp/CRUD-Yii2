<?php
 
namespace app\models;
use yii\base\model;
 
class FormUpload extends model{
  
    public $file;
     
    public function rules()
    {
        return [
            ['file', 'file', 
   'skipOnEmpty' => false,
   'uploadRequired' => 'Nenhum arquivo selecionado', //Error
   'maxSize' => 1024*1024*1, //1 MB
   'tooBig' => 'Tamanho máximo de 1MB', //Error
   'minSize' => 10, //10 Bytes
   'tooSmall' => 'Tamanho mínimo de 10 BYTES', //Error
   'extensions' => 'pdf, txt, doc',
   'wrongExtension' => 'O arquivo {file} não está entre os permitidos {extensions}', //Error
   'maxFiles' => 1,
   'tooMany' => 'O máximo de arquivos são {limit}', //Error
   ],
        ]; 
    } 
 
 public function attributeLabels()
 {
  return [
   'file' => 'Selecione arquivo:',
  ];
 }
}