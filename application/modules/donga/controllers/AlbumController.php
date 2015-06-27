<?php
class Donga_AlbumController extends Zendda_Controller_Action {
	
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
		$this->_arrParam['ssFilter']['col'] 		= 'created';
		$this->_arrParam['ssFilter']['order'] 		= 'DESC';
		
		//Truyen ra view
		$this->view->arrParam = $this->_arrParam;
		$this->view->currentController = $this->_currentController;
		$this->view->actionMain = $this->_actionMain;		
        
		$template_path = TEMPLATE_PATH . "/public/donga1";
		$this->loadTemplate ( $template_path, 'template.ini', 'template' );
		
		$title = 'Thư viện ảnh | Mầm Non Kim Đồng | www.mamnonkimdong.edu.vn';
        $this->view->headTitle ( $title, true );
	}
	
	public function indexAction() {		
        $tbl_album = new Donga_Model_Album();
        $this->view->items = $tbl_album->getListItem($this->_arrParam, array('task'=>'list-item'));
                
        $totalItem = $tbl_album->countItem($this->_arrParam, array('task'=>'count-item'));
        $paginator = new Zendda_Paginator();
		$this->view->panigator = $paginator->createPaginator($totalItem,$this->_paginator);
	}	
    
    public function viewAction() {
		$tbl_album = new Donga_Model_AlbumDetail();
        $this->view->items = $tbl_album->getListItem($this->_arrParam, array('task'=>'list-item'));
                
        $totalItem = $tbl_album->countItem($this->_arrParam, array('task'=>'count-item'));
        $paginator = new Zendda_Paginator();
		$this->view->panigator = $paginator->createPaginator($totalItem,$this->_paginator);
	}
}
