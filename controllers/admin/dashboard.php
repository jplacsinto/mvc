<?php
class Dashboard extends Controller{
    function __construct(){
        parent::__construct();
    }

    function index(){
        Session::init();
        $loggedIn = Session::get('loggedin');
        if(!$loggedIn){
            Session::destroy();
            header('location: '.BASE_URL.'admin/login');
            exit;
        }
    }
}