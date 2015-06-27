<?php
class AdminGroupController extends Zendda_Controller_Action{
    
    //Mang tham so nhan dc o moi Action
    protected $_arrParams;
    
    //Duong dan cua Controller
    protected $_currentController;
    
    //Duong dan cua Action chay chinh
    protected $_mainAction;
    
    //Thong so phan trang
	protected $_paginator = array(
									'itemCountPerPage' => 5,
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
			$ssFilter->col 			= 'g.id';
			$ssFilter->order 		= 'DESC';
		}
		$this->_arrParams['ssFilter']['keywords'] 	= $ssFilter->keywords;
		$this->_arrParams['ssFilter']['col'] 		= $ssFilter->col;
		$this->_arrParams['ssFilter']['order'] 		= $ssFilter->order;
		
        //Truyen ra view
        $this->view->arrParams = $this->_arrParams;
        $this->view->currentController = $this->_currentController;
        $this->view->mainAction = $this->_mainAction;
        
        $template_path = TEMPLATE_PATH . "/admin/system";
        $this->loadTemplate($template_path,'template.ini','template');
    }
    
    public function indexAction(){
        $this->view->Title = 'Thành viên :: Quản lý nhóm :: Danh sách';
        $this->view->headTitle($this->view->Title,true);
        $tableGroup = new Default_Model_UserGroup();
        $this->view->items = $tableGroup->listItems($this->_arrParams,array('task'=>'admin-list'));
        
        $totalItem  = $tableGroup->countItem($this->_arrParams);
		
		$paginator = new Zendda_Paginator();
		$this->view->panigator = $paginator->createPaginator($totalItem,$this->_paginator);
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
		
		if($this->_arrParams['type'] == 'order'){
			$ssFilter->col = $this->_arrParams['col'];
			$ssFilter->order = $this->_arrParams['by'];
		}
	
		$this->_redirect($this->_mainAction);
		$this->_helper->viewRenderer->setNoRender();
	}
    
    public function addAction(){
        $this->view->Title = 'Thành viên :: Quản lý nhóm :: Thêm mới';
        $this->view->headTitle($this->view->Title,true);
        if($this->_request->isPost()){
            $validator = new Default_Form_ValidateUserGroup($this->_arrParams);
            if($validator->isError()==true){
                $this->view->messageError = $validator->getMessageError();   
                $this->view->dataRight = $validator->getData(); 
            }else{
                $arrParam = $validator->getData(array('upload'=>true));
                $tableGroup = new Default_Model_UserGroup();
                $tableGroup->saveItem($arrParam,array('task'=>'admin-add'));
                $this->_redirect($this->_mainAction);
            }
        }
    }
    
    public function infoAction(){
        $this->view->Title = 'Thành viên :: Quản lý nhóm :: Thông tin chi tiết';
        $this->view->headTitle($this->view->Title,true);
        $tableGroup = new Default_Model_UserGroup();
        $this->view->item = $tableGroup->getItem($this->_arrParams,array('task'=>'admin-info'));
       
    }
    
    public function editAction(){
        $this->view->Title = 'Thành viên :: Quản lý nhóm :: Sửa';
        $this->view->headTitle($this->view->Title,true);
        $tableGroup = new Default_Model_UserGroup();
        $this->view->item = $tableGroup->getItem($this->_arrParams,array('task'=>'admin-edit'));
        if($this->_request->isPost()){
            $validator = new Default_Form_ValidateUserGroup($this->_arrParams);
            if($validator->isError()==true){
                $this->view->messageError = $validator->getMessageError();
                $this->view->dataRight = $validator->getData();
            }else{
                $arrParam = $validator->getData(array('upload'=>true));
                $tableGroup = new Default_Model_UserGroup();
                $tableGroup->saveItem($arrParam,array('task'=>'admin-edit'));
                $this->_redirect($this->_mainAction);
            }
            
        }
    }
    
    public function deleteAction(){
        $this->view->Title = 'Thành viên :: Quản lý nhóm :: Xoá';
        $this->view->headTitle($this->view->Title,true);
        if($this->_request->isPost()){
            $tableGroup = new Default_Model_UserGroup();
            $tableGroup->deleteItem($this->_arrParams,array('task'=>'admin-delete'));
            $this->_redirect($this->_mainAction);
        }
    }
    
    public function statusAction(){
        
        $tableGroup = new Default_Model_UserGroup();
        $tableGroup->changeStatus($this->_arrParams);
        $this->_redirect($this->_mainAction);
        $this->_helper->viewRenderer->setNoRender();
    }
    
    public function multiDeleteAction(){
       
        if($this->_request->isPost()){
            $tableGroup = new Default_Model_UserGroup();
            $tableGroup->deleteItem($this->_arrParams,array('task'=>'admin-multi-delete'));
            $this->_redirect($this->_mainAction);
        }
        $this->_helper->viewRenderer->setNoRender();
    }
    
    public function sortAction(){
        if($this->_request->isPost()){
            $tableGroup = new Default_Model_UserGroup();
            $tableGroup->sortItem($this->_arrParams,array('task'=>'admin-sort'));
            $this->_redirect($this->_mainAction);
        }
        $this->_helper->viewRenderer->setNoRender();
    }
}