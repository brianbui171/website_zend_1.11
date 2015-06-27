<?php
class AdminController extends Zendda_Controller_Action{
    public function init(){
        $template_path = TEMPLATE_PATH . "/admin/system";
        $this->loadTemplate($template_path,'template.ini','template');
    }
    
    public function indexAction(){
        echo __METHOD__;
        /*$info = new Zendvn_System_Info();
        $info = $info->getInfo();
        echo '<pre>';
        echo print_r($info);
        echo '</pre>';*/
    }
}