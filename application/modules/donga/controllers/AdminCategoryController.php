<?php
class Donga_AdminCategoryController extends Zendda_Controller_Action{
    
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
		}
		$this->_arrParams['ssFilter']['keywords'] 	= $ssFilter->keywords;
		
        //Truyen ra view
        $this->view->arrParams = $this->_arrParams;
        $this->view->currentController = $this->_currentController;
        $this->view->mainAction = $this->_mainAction;
        
        $template_path = TEMPLATE_PATH . "/admin/system";
        $this->loadTemplate($template_path,'template.ini','template');
    }
    
    public function indexAction(){
        $this->view->Title = 'Chuyên mục :: Quản lý chuyên mục :: Danh sách';
        $this->view->headTitle($this->view->Title,true);
        $tblCategory = new Donga_Model_Category();
        $this->view->items = $tblCategory->listItems($this->_arrParams,array('task'=>'admin-list'));
        
    }
    
    public function addAction(){
        $this->view->Title = 'Chuyên mục :: Quản lý chuyên mục :: Thêm mới';
        $this->view->headTitle($this->view->Title,true);
        $tblCategory = new Donga_Model_Category();
        $this->view->selectBox = $tblCategory->itemInSelectbox();
        if($this->_request->isPost()){
            $tblCategory->saveItem($this->_arrParams,array('task'=>'admin-add'));
            $this->_redirect($this->_mainAction);
        }       
    }
    
    public function editAction(){        
    	$tblCategory = new Donga_Model_Category();
        if($this->_request->isPost()){
           	$tblCategory->saveItem($this->_arrParams,array('task'=>'admin-edit'));            
            $this->_redirect($this->_mainAction);
        } else {
        	$this->view->Title = 'Chuyên mục :: Quản lý chuyên mục :: Sửa';
	        $this->view->headTitle($this->view->Title,true);	        
	        $this->view->selectBox = $tblCategory->itemInSelectbox($this->_arrParams,array('task'=>'admin-edit'));
	        $this->view->item = $tblCategory->getItem($this->_arrParams,array('task'=>'admin-edit'));
        }
    }
    
    public function deleteAction(){
        $this->view->Title = 'Chuyên mục :: Quản lý chuyên mục :: Xoá';
        $this->view->headTitle($this->view->Title,true);
        if($this->_request->isPost()){
            $tblCategory = new Donga_Model_Category();
            $tblCategory->deleteItem($this->_arrParams,array('task'=>'admin-delete'));
            $this->_redirect($this->_mainAction);
        }
    }
    
    public function statusAction(){
        $tblCategory = new Donga_Model_Category();
        $tblCategory->changeStatus($this->_arrParams);
        $this->_redirect($this->_mainAction);
        $this->_helper->viewRenderer->setNoRender();
    }
    
    public function sortAction(){
        if($this->_request->isPost()){
            $tblCategory = new Donga_Model_Category();
            $tblCategory->sortItem($this->_arrParams,array('task'=>'admin-sort'));
            $this->_redirect($this->_mainAction);
        }
        $this->_helper->viewRenderer->setNoRender();
    }
    
    public function filterAction(){
        echo '<br>' . __METHOD__;
        $this->_helper->viewRenderer->setNoRender();
    }
    
    public function infoAction(){
        $this->view->Title = 'Chuyên mục :: Quản lý chuyên mục :: Thông tin chi tiết';
        $this->view->headTitle($this->view->Title,true);
        $tblCategory = new Donga_Model_Category();
        $this->view->item = $tblCategory->getItem($this->_arrParams,array('task'=>'admin-info'));
      
    }
    
    public function multiDeleteAction(){
        if($this->_request->isPost()){
            $tblCategory = new Donga_Model_Category();
            $tblCategory->deleteItem($this->_arrParams,array('task'=>'admin-multi-delete'));
            $this->_redirect($this->_mainAction);
        }
        $this->_helper->viewRenderer->setNoRender();
    }
    
}