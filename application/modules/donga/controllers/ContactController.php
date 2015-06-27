<?php
class Donga_ContactController extends Zendda_Controller_Action {
	
	//Mang tham so nhan duoc o moi Action
	protected $_arrParam;
	
	//Duong dan cua Controller
	protected $_currentController;
	
	//Duong dan cua Action chinh
	protected $_actionMain;
	
	//Thong so phan trang
	protected $_paginator = array ('itemCountPerPage' => 12, 'pageRange' => 4 );
	
	public function init() {
		
		//Mang tham so nhan duoc o moi Action
		$this->_arrParam = $this->_request->getParams ();
		
		//Duong dan cua Controller
		$this->_currentController = '/' . $this->_arrParam ['module'] . '/' . $this->_arrParam ['controller'];
		
		//Duong dan cua Action chinh		
		$this->_actionMain = '/' . $this->_arrParam ['module'] . '/' . $this->_arrParam ['controller'] . '/index';
				
		$this->_paginator ['currentPage'] = $this->_request->getParam ( 'page', 1 );
		$this->_arrParam ['paginator'] = $this->_paginator;
		
		//Truyen ra view
		$this->view->arrParam = $this->_arrParam;
		$this->view->currentController = $this->_currentController;
		$this->view->actionMain = $this->_actionMain;
		
		$template_path = TEMPLATE_PATH . "/public/donga1";
		$this->loadTemplate ( $template_path, 'template.ini', 'template' );
	}
	
	public function indexAction() {
		$flag = true;
		$captcha = new Zendda_Captcha_Image();
		//9.Truyen gia tri cua CAPTCHA ra VIEW
		$this->view->captcha = $captcha->render($this->view);
		$this->view->captcha_id = $captcha->getId();
		
		if($this->_request->isPost()){			
			$captchaID = $this->_arrParam['captchaID'];
			$valueCaptcha = $this->_arrParam['captcha'];
			$validatorForm = new Donga_Form_ValidateContact($this->_arrParam);	
				
			if($validatorForm->isError() == true){
				$flag = false;
                $this->view->messageErrorForm = $validatorForm->getMessageError();                
            }
            
			$validatorCaptcha = new Zendda_Validate_Captcha($captchaID);			
			if(!$validatorCaptcha->isValid($valueCaptcha)){
				$flag = false;
				$errors = $validatorCaptcha->getMessages();
				$this->view->messageErrorCaptcha = $errors;
			}		
			
			$captcha->removeImg($captchaID);
			
			if($flag == true) {
				$tbl_qa = new Donga_Model_QuestionAnswer();
				$tbl_qa->saveItem($validatorForm->getData(),array('task'=>'admin-add'));
			} else {
				$this->view->dataRight = $validatorForm->getData();
			}
		}
	}
	
	public function registerEnterLearningAction() {
		
	}
	
	public function ajaxCaptchaAction() {
		$captcha = new Zendda_Captcha_Image();
		//9.Truy gia tri cua CAPTCHA ra VIEW
		$this->view->captcha = $captcha->render($this->view);
		$this->view->captcha_id = $captcha->getId();
		$this->_helper->layout->disableLayout();
	}
	
	public function answerAction() {
		$tbl_qa = new Donga_Model_QuestionAnswer();
		$title = 'Hỏi - Đáp | Mầm Non Kim Đồng | www.mamnonkimdong.edu.vn';
		$this->view->headTitle ( $title, true );
		$this->_arrParam['ssFilter']['is_answer'] = 1;
		$this->_arrParam['ssFilter']['status'] = 1;
		$this->_arrParam['ssFilter']['col'] = 'created';
		$this->_arrParam['ssFilter']['order'] = 'DESC';
		$this->view->items = $tbl_qa->listItems( $this->_arrParam, array ('task' => 'admin-list' ) );
		$totalItem  = $tbl_qa->countItem($this->_arrParam,array('task'=>'public-qa'));
		$paginator = new Zendda_Paginator();
		$this->view->panigator = $paginator->createPaginator($totalItem,$this->_paginator);
	}
	
	public function answerDetailAction() {
		$tbl_qa = new Donga_Model_QuestionAnswer();
		$this->view->item = $tbl_qa->getItem( $this->_arrParam, array ('task' => 'admin-info' ) );
		$this->_arrParam['ssFilter']['is_answer'] = 1;
		$this->_arrParam['ssFilter']['status'] = 1;
		$this->_arrParam['ssFilter']['other_id'] = $this->_arrParam['id'];
		$this->_arrParam['ssFilter']['col'] = 'created';
		$this->_arrParam['ssFilter']['order'] = 'DESC';
		$this->view->itemRelate = $tbl_qa->listItems( $this->_arrParam, array ('task' => 'admin-list' ) );	
		$title = $this->view->item['title'].' | Mầm Non Kim Đồng | www.mamnonkimdong.edu.vn';
		$this->view->headTitle ( $title, true );
	}
}
