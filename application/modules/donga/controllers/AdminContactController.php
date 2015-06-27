<?php
class Donga_AdminContactController extends Zendda_Controller_Action{
    
    //Mang tham so nhan dc o moi Action
    protected $_arrParams;
    
    //Duong dan cua Controller
    protected $_currentController;
    
    //Duong dan cua Action chay chinh
    protected $_mainAction;
    
    //Thong so phan trang
	protected $_paginator = array(
									'itemCountPerPage' => 10,
									'pageRange' => 3,
								  );
    
	protected $_namespace;
	
    public function init(){
        //Mang tham so nhan dc o moi Action
        $this->_arrParams = $this->_request->getParams();
        
        //Duong dan cua Controller
        $this->_currentController = '/' . $this->_arrParams['module'] .
                                    '/' . $this->_arrParams['controller'];
        
        //Duong dan cua Action chay chinh
        $this->_mainAction = '/' . $this->_arrParams['module'] .
                             '/' . $this->_arrParams['controller'] . '/index';
        
        $this->_paginator['currentPage'] = $this->_request->getParam('page',1);
		$this->_arrParams['paginator'] = $this->_paginator;
        
		//Dat ten namespace
		$this->_namespace = $this->_arrParams['module'] . '-' . $this->_arrParams['controller'];
		
		//Tao session filter
		$ssFilter = new Zend_Session_Namespace($this->_namespace);
		//$ssFilter->unsetAll();
		if(empty($ssFilter->col)){
			$ssFilter->keywords 	= '';
			$ssFilter->col 			= 'created';
			$ssFilter->order 		= 'DESC';
		}
		$this->_arrParams['ssFilter']['keywords'] 	= $ssFilter->keywords;
		$this->_arrParams['ssFilter']['col'] 		= $ssFilter->col;
		$this->_arrParams['ssFilter']['order'] 		= $ssFilter->order;
		$this->_arrParams['ssFilter']['is_answer'] 		= $ssFilter->is_answer;
		
        //Truyen ra view
        $this->view->arrParams = $this->_arrParams;
        $this->view->currentController = $this->_currentController;
        $this->view->mainAction = $this->_mainAction;
        
        $template_path = TEMPLATE_PATH . "/admin/system";
        $this->loadTemplate($template_path,'template.ini','template');
    }
    
    public function indexAction(){
        $this->view->Title = 'Chuyên mục :: Hỏi - Đáp :: Danh sách';
        $this->view->headTitle($this->view->Title,true);
        $tblItem = new Donga_Model_QuestionAnswer();
        $this->view->items = $tblItem->listItems($this->_arrParams,array('task'=>'admin-list'));
                
        $totalItem  = $tblItem->countItem($this->_arrParams);
		$paginator = new Zendda_Paginator();
		$this->view->panigator = $paginator->createPaginator($totalItem,$this->_paginator);
    }
    
    public function editAction(){
        $this->view->Title = 'Chuyên mục :: Hỏi - Đáp :: Sửa';
        $this->view->headTitle($this->view->Title,true);
        $tblItem = new Donga_Model_QuestionAnswer();
        $this->view->item = $tblItem->getItem($this->_arrParams,array('task'=>'admin-edit'));
        
        if($this->_request->isPost()){  
                $tblItem = new Donga_Model_QuestionAnswer();
                $tblItem->saveItem($this->_arrParams,array('task'=>'admin-edit'));
                $this->sendMail($this->_arrParams);
                $this->_redirect($this->_mainAction);
        }
    }
    
    public function deleteAction(){
       $this->view->Title = 'Chuyên mục :: Hỏi - Đáp :: Xoá';
       $this->view->headTitle($this->view->Title,true);
       if($this->_request->isPost()){
           $tblItem = new Donga_Model_QuestionAnswer();
           $tblItem->deleteItem($this->_arrParams,array('task'=>'admin-delete'));
           $this->_redirect($this->_mainAction);
       }
    }
    
    public function statusAction(){
        $tblItem = new Donga_Model_QuestionAnswer();
        $tblItem->changeStatus($this->_arrParams);
        $this->_redirect($this->_mainAction);
        $this->_helper->viewRenderer->setNoRender();
    }
    
    public function filterAction(){
        $ssFilter = new Zend_Session_Namespace($this->_namespace);
		
		if($this->_arrParams['type'] == 'search'){
			if($this->_arrParams['key'] == 1){
				$ssFilter->keywords = trim($this->_arrParams['keywords']);
			}else{
				$ssFilter->keywords = '';
			}
		}
		
         if($this->_arrParams['type'] == 'is_answer'){
			$ssFilter->is_answer = $this->_arrParams['is_answer'];
		}
		
		if($this->_arrParams['type'] == 'order'){
			$ssFilter->col = $this->_arrParams['col'];
			$ssFilter->order = $this->_arrParams['by'];
		}
	
		$this->_redirect($this->_mainAction);
		$this->_helper->viewRenderer->setNoRender();
    }
    
    public function infoAction(){
        $this->view->Title = 'Chuyên mục :: Hỏi - Đáp :: Chi tiết';
        $this->view->headTitle($this->view->Title,true);
        $tblItem = new Donga_Model_QuestionAnswer();
        $this->view->item = $tblItem->getItem($this->_arrParams,array('task'=>'admin-info'));
    }
    
    public function multiDeleteAction(){
        if($this->_request->isPost()){
           $tblItem = new Donga_Model_QuestionAnswer();
           $tblItem->deleteItem($this->_arrParams,array('task'=>'admin-multi-delete'));
           $this->_redirect($this->_mainAction);
           $this->_helper->viewRenderer->setNoRender();
        }
        
    }
    
    public function sendMail($arrParam) {
		$host = 'mail.mamnonkimdong.edu.vn';
		$body = 'Câu hỏi: '.$arrParam['question'].'<br><br>'.'Trả lời: '.$arrParam['answer'];
		$email = $arrParam['email'];
		$name = $arrParam['fullname'];
		$config = array('auth'=>'login',
						'username'=>'mnkimdonginfo@mamnonkimdong.edu.vn',
						'password'=>'123456');
		$transport = new Zend_Mail_Transport_Smtp($host, $config);
		
		$mail = new Zend_Mail('utf-8');
		$mail->setFrom('mnkimdonginfo@mamnonkimdong.edu.vn', 'Trường Mầm Non Kim Đồng');
		$mail->addTo($email, $name);
		$mail->setSubject($arrParam['title']);
		$mail->setBodyHtml($body,'utf-8');
		$mail->send($transport);		
	} 
	
	public function sendGmailMail($arrParam) {
		$host = 'smtp.gmail.com';
		$body = 'Câu hỏi: '.$arrParam['question'].'<br><br>'.'Trả lời: '.$arrParam['answer'];
		$email = $arrParam['email'];
		$name = $arrParam['fullname'];
		$config = array('auth'=>'login',
						'ssl'=>'tls',
						'port'=>587,
						'username'=>'tienvinh171@gmail.com',
						'password'=>'pemun1408');
		$transport = new Zend_Mail_Transport_Smtp($host, $config);
		
		$mail = new Zend_Mail('utf-8');
		$mail->setFrom('tienvinh171@gmail.com', 'Trường Mầm Non Kim Đồng');
		$mail->addTo($email, $name);
		$mail->setSubject($arrParam['title']);		
		$mail->setBodyHtml($body,'utf-8');
		$mail->send($transport);
	} 
    
}