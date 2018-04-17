<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>
<a href="<?= Url::toRoute("site/listar")?>">Listar alunos</a>
<h1>1° Cadastro no BD com Yii</h1>
<div class="alert alert-primary" role="alert"><?=$msg?></div>
<?php
$form = ActiveForm::begin(
                ["method" => "post",
                    "enableClientValidation" => true]);
?>

<div class="form-group">
<?= $form->field($model, "nome")->input("text"); ?>
</div>

<div class="form-group">
<?= $form->field($model, "sobrenome")->input("text"); ?>
</div>

<div class="form-group">
<?= $form->field($model, "turma")->input("text"); ?>
</div>

<div class="form-group">
<?= $form->field($model, "nota_final")->input("text"); ?>
</div>

<!--<div class="form-group">  INPUT EMAIL
 <? = $form->field($model, "email")->input("email"); ?> 
</div>-->

<?= Html::submitButton("Enviar", ["class" => "btn btn-primary"]);?>

<?php $form->end();?>