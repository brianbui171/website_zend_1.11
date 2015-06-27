<?php
class Donga_DocController extends Zendda_Controller_Action {
	
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
		
		$this->_arrParam['ssFilter']['keywords'] 	= '';
		$this->_arrParam['ssFilter']['col'] 		= 't1.created';
		$this->_arrParam['ssFilter']['order'] 		= 'DESC';
		
		//Truyen ra view
		$this->view->arrParam = $this->_arrParam;
		$this->view->currentController = $this->_currentController;
		$this->view->actionMain = $this->_actionMain;		
        
		$template_path = TEMPLATE_PATH . "/public/donga1";
		$this->loadTemplate ( $template_path, 'template.ini', 'template' );
		
		$title = 'Tài nguyên | Mầm Non Kim Đồng | www.mamnonkimdong.edu.vn';
        $this->view->headTitle ( $title, true );
	}
	
	public function indexAction() {		
        $tbl_album = new Donga_Model_Doc();
        $this->view->items = $tbl_album->getListItem($this->_arrParam, array('task'=>'list-item'));
                
        $totalItem = $tbl_album->countItem($this->_arrParam, array('task'=>'count-item'));
        $paginator = new Zendda_Paginator();
		$this->view->panigator = $paginator->createPaginator($totalItem,$this->_paginator);
	}
    
    public function viewAction() {
		$tbl_album = new Donga_Model_Doc();
        $this->view->items = $tbl_album->getListItemDtl($this->_arrParam, array('task'=>'list-item'));
                
        $totalItem = $tbl_album->countItem($this->_arrParam, array('task'=>'count-item-dtl'));
        $paginator = new Zendda_Paginator();
		$this->view->panigator = $paginator->createPaginator($totalItem,$this->_paginator);
	}
	
	public function downloadAction(){
		if(isset($this->_arrParam['file_name']) && $this->_arrParam['file_name'] != ""){
          		$pathFile = FILES_PATH . '/resource/'. $this->_arrParam['file_name'];
          		$name = basename($pathFile);
          		$fileType = filetype($pathFile);
           		$this->getResponse()
               		 ->clearAllHeaders()
                	 ->setHeader('Content-Type', 'application/octet-stream',true)
                	 ->setHeader('Content-Disposition', 'attachment; filename="'.$name.'"',true)
                	 ->setHeader('Content-Length', filesize($pathFile),true)
                	 ->setHeader('Cache-control', 'private',true);
            	readfile($pathFile);
            	$this->getResponse()->sendResponse();
		} else {
			$this->_redirect($this->_actionMain);
		}
		
		if(isset($this->_arrParam['id'])){
			$tbl_doc = new Donga_Model_DocDetail();
			$tbl_doc->hintUpdate($this->_arrParam['id']);
		}
		
       $this->_helper->layout->disableLayout();
       $this->_helper->viewRenderer->setNoRender();
	}
}
