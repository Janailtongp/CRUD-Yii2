<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\data\Pagination;
use yii\widgets\LinkPager;
?>
<a href="<?= Url::toRoute("site/create") ?>">Adicionar um novo Aluno</a>

<?php
$f = ActiveForm::begin([
            "method" => "get",
            "action" => Url::toRoute("site/listar"),
            "enableClientValidation" => true,
        ])
?>
<div class="form-group">
    <?= $f->field($form, "q")->input("search") ?>
</div>
<?= Html::submitButton("Buscar", ["class" => "btn btn-primary"]) ?>

<?php $f->end() ?>

<h3><?= $search ?></h3>


<h3>Lista de Alunos</h3>

<table class="table table-bordered">
    <tr>
        <th>ID Aluno</th>
        <th>Nome</th>
        <th>Sobrenome</th>
        <th>Turma</th>
        <th>Nota Final</th>
        <th></th>
        <th></th>
    </tr>
    <?php foreach ($model as $row): ?>
        <tr>
            <td><?= $row->id_aluno ?></td>
            <td><?= $row->nome ?></td>
            <td><?= $row->sobrenome ?></td>
            <td><?= $row->turma ?></td>
            <td><?= $row->nota_final ?></td>
            <td><a href="<?= Url::toRoute(["site/editar","id_aluno"=>$row->id_aluno, "nome"=>$row->nome])?>">Editar</a></td>
            <td>
                <a href="#" data-toggle='modal' data-target="#myModal<?= $row->id_aluno ?>">Excluir</a>
            </td>
                    <div class='modal fade' id=myModal<?= $row->id_aluno?> tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
                                <div class='modal-dialog' role='document'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                                            <h4 class='modal-title' id='myModalLabel'>Excluir registro!</h4>
                                        </div>
                                        <div class='modal-body'>
                                            <p>Deseja realmente excluir o registro de nome: <?= $row->nome?> <?= $row->sobrenome?> ?</p>    
                                        </div>
                                        <div class='modal-footer'>
                                            <?= Html::beginForm(Url::toRoute("site/delete"), "POST") ?>
                                                <input type="hidden" name="id_aluno" value="<?= $row->id_aluno?>">
                                                <button type="submit" class="btn btn-primary">Excluir</button>
                                            <?= Html::endForm()?>
                                        </div>
                                    </div>
                                </div>
                    </div>
            </tr>
<?php endforeach; ?>
</table>

<?=
LinkPager::widget([
    "pagination" => $pages,
])
?>


