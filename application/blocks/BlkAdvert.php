<?php
class Block_BlkAdvert extends Zend_View_Helper_Abstract {
	
	public function blkAdvert() {
		$view = $this->view;	
		$arrParam = $view->arrParam;
		$flagShow  = false;
		if($arrParam['action'] == 'index' && $arrParam['controller'] == 'index'){
			$flagShow  = true;
		}		
		require_once (BLOCK_PATH . '/BlkAdvert/default.php');
	}
}