<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>
<h1>Formulário</h1>

<h3><?php print_r($mensagem); ?></h3>

<?=Html::beginForm(
    Url::toRoute("site/request"),//Action
    "get", // Method
    ['class'=>'form-inline'] //options
    );
?>
        <div class="form-group"> 
            <?=Html::label("Digite seu nome: ", "Nome") ?>
            <?=Html::textInput("nome", null,["class"=>"form-control"]) ?>
        </div>
        <?=Html::submitButton("Enviar",["class"=>"btn btn-primary"]); ?>

<?= Html::endForm() ?>

     