<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\ValidarFormulario;
use app\models\FormAlunos;
use app\models\Alunos;
use app\models\FormSearch;
use yii\helpers\Html;
use yii\data\Pagination;
use yii\helpers\Url;
use app\models\FormRegister;
use app\models\Users;
use app\models\User;


class SiteController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function actionBemvindo($var = "Olá :)") {
        $mensagem = "Seja bem vindo(a)";
        $numeros = [1, 2, 3, 4, 5, 6, 7, 8, 9, 0];
        return $this->render("BemVindo", ["mensagem" => $mensagem,
                    "array" => $numeros,
                    "get" => $var]);
    }

    public function actionFormulario($mensagem = null) {
        return $this->render("Formulario", ["mensagem" => $mensagem]);
    }

    public function actionRequest() {
        $mensagem = null;
        if (isset($_REQUEST["nome"]) and ! empty($_REQUEST["nome"])) {
            $mensagem = "Ok, Seu nome é: " . $_REQUEST["nome"];
        } else {
            $mensagem = "Preencha o campo corretamente";
        }
        $this->redirect(["site/formulario", "mensagem" => $mensagem]);
    }

    public function actionValidarformulario(){
        $model = new ValidarFormulario;
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                //Aqui salvariamos no BD 
            } else {
                $model->getErrors();
            }
        }
        return $this->render("Validarformulario", ["model" => $model]);
    }
    //Cadastrar NO BD
    public function actionCreate(){
        $model = new FormAlunos;
        $msg = null;
        if($model->load(Yii::$app->request->post())){
            if($model->validate()){
                $table = new Alunos;
                $table->nome = $model->nome;
                $table->sobrenome = $model->sobrenome;
                $table->turma = $model->turma;
                $table->nota_final = $model->nota_final;
                if($table->insert()){
                    $msg =  "Dados salvos com sucesso :D";
                    $model->nome = null;
                    $model->sobrenome = null;
                    $model->turma = null;
                    $model->nota_final = null;
                }else{
                    $msg = "Erro ao salvar no banco de dados :(";
                }
            }else{
                $model->getErrors();
            }
        }
        return $this->render("cadastrar",["model"=>$model, "msg"=>$msg]);
    }
    //Listando todos os dados da tabela
    public function actionListar(){
        $form = new FormSearch;
        $search = null;
        if($form->load(Yii::$app->request->get())){
            if($form->validate()){
                $search = Html::encode($form->q);
                $table = Alunos::find()->where(["like", "id_aluno", $search])
                                       ->orWhere(["like", "nome", $search])
                                       ->orWhere(["like", "sobrenome", $search]);
                $count = clone $table;
                $pages = new Pagination([
                    "pageSize" => 2,
                    "totalCount" => $count->count(),
                ]);
                $model = $table
                        ->offset($pages->offset)
                        ->limit($pages->limit)
                        ->all();
            }else{
                $form->getErrors();
            }
        }else{
            $table = Alunos::find();
            $count = clone $table;
            $pages =  new Pagination([
                "pageSize" => 2,
                "totalCount" => $count->count(),
            ]);
            $model = $table
                    ->offset($pages->offset)
                    ->limit($pages->limit)
                    ->all();
        }
        return $this->render("listar",["model"=>$model, "form"=>$form, "search"=>$search, "pages"=>$pages]);
    }
    
    public function actionEditar() {
        $model = new FormAlunos;
        $msg = null;
        if($model->load(Yii::$app->request->post())){
            if($model->validate()){
                $table = Alunos::findOne($model->id_aluno);
                if($table){
                    $table->nome = $model->nome;
                    $table->sobrenome = $model->sobrenome;
                    $table->turma = $model->turma;
                    $table->nota_final = $model->nota_final;
                    if($table->update()){
                        $msg = "Registro atualizado com sucesso!";
                    }  else {
                        $msg = "Registro não pode ser atualizado";
                    }
                }else{
                    $msg = "Registro selecionado não encontrado!";
                }
            }else{
                $model->getErrors();
            }
        }
        
        if(Yii::$app->request->get("id_aluno")){
            $id_aluno = Html::encode($_GET['id_aluno']);
            if((int) $id_aluno){
                $table = Alunos::findOne($id_aluno);
                if($table){
                    $model->id_aluno = $table->id_aluno;
                    $model->nome = $table->nome;
                    $model->sobrenome = $table->sobrenome;
                    $model->turma = $table->turma;
                    $model->nota_final = $table->nota_final;
                }else{
                     return $this->redirect(["site/listar"]);
                }
            }  else {
                return $this->redirect(["site/listar"]);
            }
        }else{
            return $this->redirect(["site/listar"]);
        }
        return $this->render("editar",["msg"=>$msg, "model"=>$model]);
    }
    
    
    
    public function actionDelete() {
        if(Yii::$app->request->post()){
            $id_aluno = Html::encode($_POST["id_aluno"]);
                if((int) $id_aluno){
                    if(Alunos::deleteAll("id_aluno=:id_aluno",[":id_aluno" => $id_aluno])){
                        echo "Registro excluido com sucesso! ...";
                        echo "<meta http-equiv='refresh' content='3; ".Url::toRoute("site/listar")."'>";
                    }else{
                        echo "Erro ao excluir Registro, tente novamente ...";
                        echo "<meta http-equiv='refresh' content='3; ".Url::toRoute("site/listar")."'>";
                    }
                }else{
                    echo "Erro ao excluir Registro, tente novamente ...";
                    echo "<meta http-equiv='refresh' content='3; ".Url::toRoute("site/listar")."'>";
                }
        }else{
            return $this->redirect(["site/listar"]);
        }
    }

    public function actionParticipante(){
        return $this->render("participante");
       
    }
     public function actionAdmin(){
        return $this->render("admin");
       
    }
    public function actionUpload() {
        $model = new FormUpload;
        $msg = null;
        if ($model->load(Yii::$app->request->post())) {
            //Para enviar apenas um arquivo 
            $model->file = UploadedFile::getInstance($model,'file');
            $file = $model->file;
            //$file->saveAs(..)
            $msg="post";
            //$model->file = UploadedFile::getInstances($model, 'file');
            if ($model->file && $model->validate()) {
                $msg ="valodado";
                //foreach ($model->file as $file) {
                    $file->saveAs('artigos/' . 'JANAAS' . '.' . $file->extension);
                    $msg = "<p><strong class='label label-info'>Arquivo enviado com sucesso!</strong></p>";
               // }
            }
        }
        return $this->render("upload", ["model" => $model, "msg" => $msg]);
    }
    public function behaviors(){
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['logout','participante','admin', "listar","create","delete","editar"],
                'rules' => [
                    [
                        'actions' =>['logout','admin',"listar","create","delete","editar"],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' =>function($rule, $action){
                        return User::isUserAdmin(Yii::$app->user->identity->id); 
                        },
                    ],
                    [
                        'actions' =>['logout','participante',"listar"],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' =>function($rule, $action){
                        return User::isUserSimple(Yii::$app->user->identity->id); 
                        },  
                    ],
                ],                
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
   }

    /**
     * {@inheritdoc}
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex() {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin() {
        if (!Yii::$app->user->isGuest) {
            if(User::isUserAdmin(Yii::$app->user->identity->id)){
                return $this->redirect(["site/admin"]);
            }else{
                return $this->redirect(["site/participante"]);
            }
           // return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if(User::isUserAdmin(Yii::$app->user->identity->id)){
                return $this->redirect(["site/admin"]);
            }else{
                return $this->redirect(["site/participante"]);
            }
           // return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
                    'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact() {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])){
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
                    'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout() {
        return $this->render('about');
    }

    
      
}
