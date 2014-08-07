<?php
class Login extends Controller{
    function __construct(){
        parent::__construct();
        $this->view->page_title = 'Login';
    }

    function index(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $login = $this->model->run_login($_POST['username'], $_POST['password']);
            if(!empty($login)){
                echo 'yey!';
            }else{
                echo 'no!';
            }
        }

        $this->view->render('admin/login');
    }
}