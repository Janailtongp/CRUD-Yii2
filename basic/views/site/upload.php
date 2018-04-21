<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?= $msg ?>


<h3>Enviar artigo</h3>

<?php $form = ActiveForm::begin([
     "method" => "post",
     "enableClientValidation" => true,
     "options" => ["enctype" => "multipart/form-data"],
     ]);
?>

<?= $form->field($model, "file")->fileInput() ?>

<?= Html::submitButton("Enviar", ["class" => "btn btn-primary"]) ?>

<?php $form->end() ?>