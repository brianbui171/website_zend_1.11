<?php
class Block_BlkInfoHightlight extends Zend_View_Helper_Abstract {
	
	public function blkInfoHightlight() {
		$view = $this->view;
		$arrParam = $view->arrParam;
		$flagShow  = false;
		if($arrParam['action'] == 'index' && $arrParam['controller'] == 'index'){
			$flagShow  = true;
		}
		
		if($flagShow == true) {
			$db = Zend_Registry::get ( 'connectDb' );
			$select = $db->select ()
						 ->from ( 'da_news as dan', array ('news_id', 'title_news' ) )
						 ->join ( 'da_category as dac', 'dan.news_type = dac.category_id', array ('category_name','parents' ) )
						 ->where ( 'dan.status = 1' )
						 ->where ( 'dac.parents = 16' )
						 ->limit ( 10, 0 )
						 ->order ( ' dan.created DESC' );
			$rows = $db->fetchAll ( $select );
			
			require_once (BLOCK_PATH . '/BlkInfoHightlight/default.php');
		}
	}
}