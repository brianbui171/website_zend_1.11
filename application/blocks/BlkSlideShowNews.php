<?php
class Block_BlkSlideShowNews extends Zend_View_Helper_Abstract {
	
	public function blkSlideShowNews() {
		$view = $this->view;
		$arrParam = $view->arrParam;
		$flagShow  = false;
		if($arrParam['action'] == 'index' && $arrParam['controller'] == 'index'){
			$flagShow  = true;
		}
		
		if($flagShow == true) {
			$db = Zend_Registry::get ( 'connectDb' );
			$select = $db->select ()->from ( 'da_news as dan', array ('news_id', 'title_news', 'summary_news', 'img_news_sml', 'img_news_big' ) )
									->join ( 'da_category as dac', 'dan.news_type = dac.category_id', array ('category_name','parents' ) )
									->where ( 'dan.status = 1' )
									//->where ( 'DAC.PARENTS = 2 OR DAC.CATEGORY_ID = 17' )
									->where('dan.news_hot = 1')
									->limit ( 7, 0 )
									->order ( ' dan.order ASC' );
			$rows = $db->fetchAll ( $select );
			
			require_once (BLOCK_PATH . '/BlkSlideShowNews/default.php');
		}		
	}
}