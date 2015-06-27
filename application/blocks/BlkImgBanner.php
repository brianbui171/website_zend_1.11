<?php
class Block_BlkimgBanner extends Zend_View_Helper_Abstract {
	
	public function blkImgBanner() {
		$view = $this->view;
		$linkImgLibrary = $view->baseUrl('/donga/album/index/catid/28');
		//$linkVideoLibrary = $view->baseUrl('/donga/video/index/catid/0');
		$linkVideoLibrary =  "#";
		require_once (BLOCK_PATH . '/BlkImgBanner/default.php');
	}
}