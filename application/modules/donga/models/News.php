<?php
class Donga_Model_news extends Zend_Db_Table {
	
	protected $_name = 'da_news';
	protected $_primary = 'news_id';
	
	protected $_ids;
	
	public function countItem($arrParams = null, $options = null){
		if($options['task'] == 'public-category'){
			$db = Zend_Registry::get('connectDb');
			$select = $db->select()
						 ->from('da_news as dan',array('COUNT(dan.news_id) AS totalItem'))
						 ->where('dan.status = 1')
						 ->where('dan.news_type IN ' . $this->_ids);
			$result = $db->fetchOne($select);
		}
		return $result;	
	}
	
	public function getListItem($arrParams = null, $options = null) {
		$db = Zend_Registry::get ( 'connectDb' );
		
		$paginator = $arrParams ['paginator'];
		$ssFilter = $arrParams ['ssFilter'];
		
		if ($options ['task'] == 'list-category') {
			$select = $db->select ()
						 ->from ( 'da_news AS ne', array ('news_id', 'title_news', 'summary_news', 'img_news_sml', 'created' ) )
						 ->joinLeft ( 'da_category AS cat', 'cat.category_id = ne.news_type', array ('category_name' ) )
						 ->where ( 'ne.status = 1' );
			
			if ($paginator ['itemCountPerPage'] > 0) {
				$page = $paginator ['currentPage'];
				$rowCount = $paginator ['itemCountPerPage'];
				$select->limitPage ( $page, $rowCount );
			}
			
			if($ssFilter ['cat_id'] != 2){
				$select->order('ne.created DESC');
			}
			if ($ssFilter ['cat_id'] > 0) {
				$select2 = $db->select ()
							  ->from ( 'da_category AS cat', array ('cat.category_id', 'cat.category_name', 'cat.parents', 
							  										'cat.status', 'cat.order', 'cat.created_BY' ) )
							  ->where ( 'cat.status = 1' );
				$result2 = $db->fetchAll ( $select2 );
				$system = new Zendda_System_Recursive ( $result2 );
				$result2 = $system->buildArray ( $ssFilter ['cat_id'] );
				if (count ( $result2 ) > 1) {
					array_unshift ( $result2, array ('category_id' => $ssFilter ['cat_id'] ) );
					$ids = '(';
					$i = 0;
					foreach ( $result2 as $key => $value ) {
						if ($i == count ( $result2 ) - 1) {
							$ids .= $value ['category_id'] . ')';
						} else {
							$ids .= $value ['category_id'] . ',';
						}
						$i ++;
					}
					$this->_ids = $ids;
					$select->where ( 'ne.news_type IN ' . $ids );
				} else {
					$this->_ids = '('.$ssFilter ['cat_id'].')';
					$select->where ( 'ne.news_type = ? ', $ssFilter ['cat_id']);
				}
			}
			$result = $db->fetchAll ( $select );
		}
		return $result;
	}
	
	public function getItem($arrParams = null, $options = null) {
		$db = Zend_Registry::get ( 'connectDb' );		
		if($options['task'] == 'get-item'){
            $select = $db->select ()
						 ->from ( 'da_news AS ne', array ('news_id', 'title_news', 'summary_news','content_news', 'created' ) )
						 ->joinLeft ( 'da_category AS cat', 'cat.category_id = ne.news_type', array ('category_name' ) )
						 ->where('ne.news_id = ?', $arrParams['id'])
						 ->where ( 'ne.status = 1' );
			$result = $db->fetchRow( $select );
        }
        return $result;
	}
	
	public function listItemRelate($arrParams = null, $options = null) {
		$db = Zend_Registry::get ( 'connectDb' );	
		//$db = Zend_Db::factory ( $adapter, $config );	
		if($options['task'] == 'list-item-relate'){
            $select = $db->select ()
						 ->from ( 'da_news AS ne', array ('news_id', 'title_news', 'created' ) )
						 ->joinLeft ( 'da_category AS cat', 'cat.category_id = ne.news_type', array ('category_name','parents' ) )
						 ->where('ne.news_id <> ?', $arrParams['id'])
						 ->where('cat.parents = ?', $arrParams['ssFilter']['cat_id'])
						 ->where ( 'ne.status = 1' )
						 ->limit(10,0)
						 ->order('ne.created DESC');
			$result = $db->fetchAll( $select );
        }
        return $result;
	}
}