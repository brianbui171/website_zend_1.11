<?php
class Zendda_System_Recursive {
	
	protected $_sourceArr;
	public function __construct($sourceArr = null) {
		$this->_sourceArr = $sourceArr;
	}
	
	public function buildArray($parents = 0) {
		$resultArr = array ();
		$this->recursive ( $this->_sourceArr, $parents, 1, $resultArr );
		
		return $resultArr;
	}
	
	public function getparentsIdArray($id, $options = null) {
		if ($options ['type'] == 1) {
			$arrparents [] = $id;
		}
		$this->findparents ( $this->_sourceArr, $id, $arrparents );
		return $arrparents;
	}
	
	public function recursive($sourceArr, $parents = 0, $level = 1, &$resultArr) {
		if (count ( $sourceArr ) > 0) {
			foreach ( $sourceArr as $key => $value ) {
				if ($value ['parents'] == $parents) {
					$value ['level'] = $level;
					$resultArr [] = $value;
					$newparents = $value ['category_id'];
					unset ( $sourceArr [$key] );
					$this->recursive ( $sourceArr, $newparents, $level + 1, $resultArr );
				}
			}
		}
	}
	
	public function findparents($sourceArr, $id, &$arrparents) {
		foreach ( $sourceArr as $key => $value ) {
			if ($value ['category_id'] == $id) {
				if ($value ['parents'] > 0) {
					$arrparents [] = $value ['parents'];
					unset ( $sourceArr [$key] );
					$newID = $value ['parents'];
					$this->findparents ( $sourceArr, $newID, $arrparents );
				}
			}
		}
	}

}