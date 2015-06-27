<?php
class PublicController extends Zendda_Controller_Action{
    
    //Mang tham so nhan dc o moi Action
    protected $_arrParams;
    
    //Duong dan cua Controller
    protected $_currentController;
    
    //Duong dan cua Action chay chinh
    protected $_mainAction;
    
   
    public function init(){
        //Mang tham so nhan dc o moi Action
        $this->_arrParams = $this->_request->getParams();
        
        //Duong dan cua Controller
        $this->_currentController = '/' . $this->_arrParams['module'] .
                                    '/' . $this->_arrParams['controller'];
        
        //Duong dan cua Action chay chinh
        $this->_mainAction = '/' . $this->_arrParams['module'] .
                             '/' . $this->_arrParams['controller'] . '/index';
       
        //Truyen ra view
        $this->view->arrParams = $this->_arrParams;
        $this->view->currentController = $this->_currentController;
        $this->view->mainAction = $this->_mainAction;
        
        $template_path = TEMPLATE_PATH . "/admin/system";
        $this->loadTemplate($template_path,'template.ini','template');
    }
    
    public function errorAction(){
        $this->view->Title = 'Message:: Error';
        $this->view->headTitle($this->view->Title,true);
        
        $error[] = 'Chuc nang nay khong ton tai';
        $this->view->messageError = $error;
	$this->_redirect('/default/index/index',array('code'=>301));
    }
    
    public function noAccessAction(){
        $this->view->Title = 'No Access';
        $this->view->headTitle($this->view->Title,true);
        
        $error[] = 'Ban khong co quyen vao chuc nang nay!';
        $this->view->messageError = $error;
        $this->_helper->viewRenderer('error');
    }
    
    public function loginAction(){
        $this->view->Title = 'Login';
        $this->view->headTitle($this->view->Title,true);
        
        if($this->_request->isPost()){
			$auth = new Zendda_System_Auth();
			if($auth->login($this->_arrParams)){
			    
			    $info = new Zendda_System_Info();
			    $info->createInfo();
				$this->_redirect('/default/admin/index');
			}else{
			    $error[] = $auth->getError();
				$this->view->messageError = $error;
			}
		}
    }
    
    public function logoutAction(){
        $this->view->Title = 'Logout';
		$this->view->headTitle($this->view->Title,true);
		$auth = new Zendda_System_Auth();
		$auth->logout();
		
		$info = new Zendda_System_Info();
		$info->destroyInfo();
		
		$link = $this->view->baseUrl('/default/index/index');
		$linkLogin = $this->view->baseUrl('/default/public/login');
		$this->view->Notes = 'Bạn đã thoát khỏi hệ thống.
							Nhấn<a href="' . $link . '"> Trang chủ</a> để quay lại trang chủ.<br>
							Nhấn<a href="' . $linkLogin . '"> Đăng Nhập</a> để tiếp tục Đăng Nhập vào hệ thống.
						';
    }
    
    
}