<?php
class Donga_IndexController extends Zendda_Controller_Action {
	
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
		$this->_arrParam ['catid'] = $this->_request->getParam ( 'catid', "" );
		$this->_arrParam ['paginator'] = $this->_paginator;
		//Truyen ra view
		$this->view->arrParam = $this->_arrParam;
		$this->view->currentController = $this->_currentController;
		$this->view->actionMain = $this->_actionMain;
		
		$template_path = TEMPLATE_PATH . "/public/donga1";
		$this->loadTemplate ( $template_path, 'template.ini', 'template' );
	}
	
	public function indexAction() {
		$title = 'Trang chủ | Mầm Non Kim Đồng | www.mamnonkimdong.edu.vn';
		$this->view->headTitle ( $title, true );
		$this->_arrParam ['ssFilter'] ['cat_id'] = 2;
		$this->_arrParam ['paginator'] ['itemCountPerPage'] = 2;
		$tbl_news = new Donga_Model_News ();
		$this->view->cat_intro = $tbl_news->getListItem ( $this->_arrParam, array ('task' => 'list-category' ) );
		$this->_arrParam ['ssFilter'] ['cat_id'] = 10;
		$this->_arrParam ['paginator'] ['itemCountPerPage'] = 5;
		$this->view->cat_program = $tbl_news->getListItem ( $this->_arrParam, array ('task' => 'list-category' ) );
		$this->_arrParam ['ssFilter'] ['cat_id'] = 22;
		$this->_arrParam ['paginator'] ['itemCountPerPage'] = 5;
		$this->view->cat_entrance = $tbl_news->getListItem ( $this->_arrParam, array ('task' => 'list-category' ) );
		$this->_arrParam ['ssFilter'] ['cat_id'] = 16;
		$this->_arrParam ['paginator'] ['itemCountPerPage'] = 5;
		$this->view->cat_news = $tbl_news->getListItem ( $this->_arrParam, array ('task' => 'list-category' ) );
	}
	
	public function categoryAction() {
		$this->_arrParam ['ssFilter'] ['cat_id'] = $this->_arrParam['catid'];
		$tbl_category = new Donga_Model_Category();
		$cate = $tbl_category->getItem($this->_arrParam, array ('task' => 'get-item' ));
		$title = $cate['category_name'] . ' | Mầm Non Kim Đồng | www.mamnonkimdong.edu.vn';
		$this->view->headTitle ( $title, true );
		$tbl_news = new Donga_Model_News ();
		$this->view->items = $tbl_news->getListItem ( $this->_arrParam, array ('task' => 'list-category' ) );
		$totalItem  = $tbl_news->countItem($this->_arrParam,array('task'=>'public-category'));
		$paginator = new Zendda_Paginator();
		$this->view->panigator = $paginator->createPaginator($totalItem,$this->_paginator);
	}
	
	public function categoryChildAction() {
		$this->_arrParam ['ssFilter'] ['cat_id'] = $this->_arrParam['id'];
		$tbl_category = new Donga_Model_Category();
		$cate = $tbl_category->getItem($this->_arrParam, array ('task' => 'get-item' ));
		$title = $cate['category_name'] . ' | Mầm Non Kim Đồng | www.mamnonkimdong.edu.vn';
		$this->view->headTitle ( $title, true );
		$tbl_news = new Donga_Model_News ();
		$this->view->items = $tbl_news->getListItem ( $this->_arrParam, array ('task' => 'list-category' ) );
		$totalItem  = $tbl_news->countItem($this->_arrParam,array('task'=>'public-category'));
		$paginator = new Zendda_Paginator();
		$this->view->panigator = $paginator->createPaginator($totalItem,$this->_paginator);
	}
	
	public function viewDetailAction() {
		$this->_arrParam ['ssFilter'] ['cat_id'] = $this->_arrParam['catid'];
		$tbl_category = new Donga_Model_Category();
		$cate = $tbl_category->getItem($this->_arrParam, array ('task' => 'get-item' ));
				
		$this->view->category = $cate;
		$tbl_news = new Donga_Model_News ();
		$this->view->item = $tbl_news->getItem ( $this->_arrParam, array ('task' => 'get-item' ) );	
		$this->view->itemRelate = $tbl_news->listItemRelate( $this->_arrParam, array ('task' => 'list-item-relate' ) );		
		
		$title = $this->view->item['title_news'].' | '.$cate['category_name'] . ' | Mầm Non Kim Đồng | www.mamnonkimdong.edu.vn';
		$this->view->headTitle ( $title, true );
	}
	
	public function itemHitsAction() {
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender();
	}
}
