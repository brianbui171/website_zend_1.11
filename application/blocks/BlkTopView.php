<?php
class Block_BlkTopView extends Zend_View_Helper_Abstract {
	
	public function blkTopView() {
		$view = $this->view;
		$db = Zend_Registry::get ( 'connectDb' );
		$select = $db->select ()
					 ->from ( 'da_news as dan', array ('news_id', 'title_news' ) )
					 ->join ( 'da_category as dac', 'dan.news_type = dac.category_id', array ('category_name','parents' ) )
					 ->where ( 'dan.status = 1' )
					 ->limit ( 5, 0 )
					 ->order ( ' dan.hits DESC' );
		$rows = $db->fetchAll ( $select );
		require_once (BLOCK_PATH . '/BlkTopView/default.php');
	}
}