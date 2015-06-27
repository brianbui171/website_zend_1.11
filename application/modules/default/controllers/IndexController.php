<?php
class IndexController extends Zendda_Controller_Action {
	//Mang tham so nhan duoc o moi Action
	protected $_arrParam;
	
	//Duong dan cua Controller
	protected $_currentController;
	
	//Duong dan cua Action chinh
	protected $_actionMain;
	
	public function init() {
		
		//Mang tham so nhan duoc o moi Action
		$this->_arrParam = $this->_request->getParams ();
		
		//Duong dan cua Controller
		$this->_currentController = '/' . $this->_arrParam ['module'] . '/' . $this->_arrParam ['controller'];
		
		//Duong dan cua Action chinh		
		$this->_actionMain = '/' . $this->_arrParam ['module'] . '/' . $this->_arrParam ['controller'] . '/index';
		
		//Truyen ra view
		$this->view->arrParam = $this->_arrParam;
		$this->view->currentController = $this->_currentController;
		$this->view->actionMain = $this->_actionMain;
		
		$template_path = TEMPLATE_PATH . "/public/donga1";
		$this->loadTemplate ( $template_path, 'template.ini', 'template' );
	
	}
	
	public function indexAction() {
		
		$this->_forward ( 'index', 'index', 'donga' );
	}
}