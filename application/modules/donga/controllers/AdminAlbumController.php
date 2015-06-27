<?php
class Donga_AdminAlbumController extends Zendda_Controller_Action{
    
    //Mang tham so nhan dc o moi Action
    protected $_arrParams;
    
    //Duong dan cua Controller
    protected $_currentController;
    
    //Duong dan cua Action chay chinh
    protected $_mainAction;
    
    //Thong so phan trang
	protected $_paginator = array(
									'itemCountPerPage' => 9,
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
		
        //Truyen ra view
        $this->view->arrParams = $this->_arrParams;
        $this->view->currentController = $this->_currentController;
        $this->view->mainAction = $this->_mainAction;
        
        $template_path = TEMPLATE_PATH . "/admin/system";
        $this->loadTemplate($template_path,'template.ini','template');
    }
    
    public function indexAction(){
        $this->view->Title = 'Chuyên mục :: Quản lý hình ảnh :: Danh sách';
        $this->view->headTitle($this->view->Title,true);
        $tblItem = new Donga_Model_Album();
        $this->view->items = $tblItem->getlistItem($this->_arrParams,array('task'=>'list-item'));
                
        $totalItem  = $tblItem->countItem($this->_arrParams, array('task'=>'count-item'));
		$paginator = new Zendda_Paginator();
		$this->view->panigator = $paginator->createPaginator($totalItem,$this->_paginator);
    }
    
	public function addAction(){
		$this->view->Title = 'Chuyên mục :: Quản lý hình ảnh :: Thêm album';
        $this->view->headTitle($this->view->Title,true);        
        
		if($this->_request->isPost()){
            $validator = new Donga_Form_ValidateAlbum($this->_arrParams);
            if($validator->isError() == true){
                $this->view->messageError = $validator->getMessageError();
                $this->view->dataRight = $validator->getData();
            }else{
                $arrParams = $validator->getData(array('upload'=>true));
                $tblItem = new Donga_Model_Album();
                $tblItem->saveItem($arrParams,array('task'=>'admin-add'));
                $this->_redirect($this->_mainAction);
            }
        }
    }
    
    public function editAction(){
        $this->view->Title = 'Chuyên mục :: Quản lý hình ảnh :: Sửa';
        $this->view->headTitle($this->view->Title,true);
        $tblItem = new Donga_Model_Album();
        $this->view->item = $tblItem->getItem($this->_arrParams,array('task'=>'admin-info'));
        
        $this->_arrParams['album_id'] = $this->_arrParams['id'];
        $tbl_albumDtl = new Donga_Model_AlbumDetail();
        $this->view->image = $tbl_albumDtl->getListItem($this->_arrParams, array('task'=>'list-item'));
                
        $totalItem = $tbl_albumDtl->countItem($this->_arrParams, array('task'=>'count-item'));
        $paginator = new Zendda_Paginator();
		$this->view->panigator = $paginator->createPaginator($totalItem,$this->_paginator);
        
        if($this->_request->isPost()){
        	$validator = new Donga_Form_ValidateAlbum($this->_arrParams);
            if($validator->isError() == true){
                $this->view->messageError = $validator->getMessageError();
                $this->view->dataRight = $validator->getData();
            }else{
                $arrParams = $validator->getData(array('upload'=>true));
                $tblItem = new Donga_Model_Album();
                $tblItem->saveItem($arrParams,array('task'=>'admin-edit'));
                $this->_redirect($this->_mainAction);
            }
        }
    }

    public function ajaxImageAction(){
    	$tbl_albumDtl = new Donga_Model_AlbumDetail();
        $this->view->image = $tbl_albumDtl->getListItem($this->_arrParams, array('task'=>'list-item'));
                
        $totalItem = $tbl_albumDtl->countItem($this->_arrParams, array('task'=>'count-item'));
        $paginator = new Zendda_Paginator();
		$this->view->panigator = $paginator->createPaginator($totalItem,$this->_paginator);
		$this->_helper->layout->disableLayout();
    } 
    
	public function deleteImageAction(){       
       if($this->_request->isPost()){
           $tblItem = new Donga_Model_AlbumDetail();
           if($tblItem->deleteItem($this->_arrParams,array('task'=>'admin-delete'))){
           		$this->_redirect($this->_currentController . '/ajax-image/album_id/'.$this->_arrParams['album_id']);
           }
           $this->_helper->layout->disableLayout();
           $this->_helper->viewRenderer->setNoRender();
       }
    }
    
    public function deleteAction(){
       $this->view->Title = 'Chuyên mục :: Quản lý hình ảnh :: Xoá';
       $this->view->headTitle($this->view->Title,true);
       if($this->_request->isPost()){
           $tblItem = new Donga_Model_Album();
           $tblItem->deleteItem($this->_arrParams,array('task'=>'admin-delete'));
           $this->_redirect($this->_mainAction);           
       }
    }
    
    public function statusAction(){
        $tblItem = new Donga_Model_Album();
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
		
		if($this->_arrParams['type'] == 'order'){
			$ssFilter->col = $this->_arrParams['col'];
			$ssFilter->order = $this->_arrParams['by'];
		}
	
		$this->_redirect($this->_mainAction);
		$this->_helper->viewRenderer->setNoRender();
    }
    
    public function infoAction(){
        $this->view->Title = 'Chuyên mục :: Quản lý hình ảnh :: Chi tiết';
        $this->view->headTitle($this->view->Title,true);
        $tblItem = new Donga_Model_Album();
        $this->view->item = $tblItem->getItem($this->_arrParams,array('task'=>'admin-info'));
    }
    
    public function multiDeleteAction(){
        if($this->_request->isPost()){
           $tblItem = new Donga_Model_Album();
           $tblItem->deleteItem($this->_arrParams,array('task'=>'admin-multi-delete'));
           $this->_redirect($this->_mainAction);
           $this->_helper->viewRenderer->setNoRender();
        }        
    }    

    public function saveImageAction(){
    	$tbl_albumDtl = new Donga_Model_AlbumDetail();
    	$tbl_albumDtl->saveItem($this->_arrParams,array('task'=>'admin-add'));
    	$this->_redirect($this->_currentController . '/ajax-image/album_id/'.$this->_arrParams['album_id']);
    	$this->_helper->layout->disableLayout();
    	$this->_helper->viewRenderer->setNoRender();
    }
}