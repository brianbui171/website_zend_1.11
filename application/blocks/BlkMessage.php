<?php
class Block_BlkMessage extends Zend_View_Helper_Abstract {
	
	public function blkMessage() {
		$view = $this->view;
		require_once (BLOCK_PATH . '/BlkMessage/default.php');
	}
}