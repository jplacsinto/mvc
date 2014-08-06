<?php
class Index extends Controller{
    function __construct(){
        parent::__construct();
    }

    function index(){
        $this->data['sample'] = array('sample', md5('kusipet'));
        $this->view->page_title = 'Custom page title';
        $this->view->render(array('admin/header','admin/index', 'admin/footer'), $this->data);
    }

}