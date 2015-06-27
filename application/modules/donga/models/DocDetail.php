<?php
class Donga_Model_DocDetail extends Zend_Db_Table {
	
	protected $_name = 'da_doc_dtl';
	protected $_primary = 'id';
	protected $_doc_type;
	
	public function countItem($arrParams = null, $options = null){
		if($options['task'] == 'count-item'){
			$db = Zend_Registry::get('connectDb');
			$select = $db->select()
						 ->from('da_doc_dtl as t1',array('COUNT(t1.id) AS totalItem'))
						 ->where('t1.status = 1')
						 ->where('t1.doc_type = ?', $this->_doc_type);
			$result = $db->fetchOne($select);
		}
		return $result;	
	}
	
	public function getListItem($arrParams = null, $options = null) {
		$db = Zend_Registry::get ( 'connectDb' );
		
		$this->_doc_type = $arrParams['doc_type'];
		$paginator = $arrParams ['paginator'];
		
		if ($options ['task'] == 'list-item') {
			$select = $db->select ()
						 ->from ('da_doc_dtl as t1')
						 ->joinLeft ( 'da_doc as t2', 't1.doc_type = t2.id', array ('doc_name' ) )
						 ->where ('t1.status = 1')
						 ->where('t1.doc_type = ?', $this->_doc_type);
			
			if ($paginator ['itemCountPerPage'] > 0) {
				$page = $paginator ['currentPage'];
				$rowCount = $paginator ['itemCountPerPage'];
				$select->limitPage ( $page, $rowCount );
			}
	
			$select->order('t1.created DESC');
			
			$result = $db->fetchAll ( $select );
		}
		return $result;
	}
	
	public function deleteItem($arrParams = null,$Option = null){
        if($Option['task'] == 'admin-delete'){          
            $where = 'id = ' . $arrParams['id'];
            $this->delete($where);
        }
        
        if($Option['task'] == 'admin-multi-delete'){
            if(count($arrParams['cid'])>0){                
                $cid = implode(',',$arrParams['cid']);
                $where = 'id IN (' . $cid . ')';
                $this->delete($where);
            }
        }
    }
	
	public function getItem($arrParams = null, $options = null) {
		$db = Zend_Registry::get ( 'connectDb' );		
		if($options['task'] == 'get-item'){
            $select = $db->select ()
						 ->from ( 'da_doc_dtl AS t1', array ('t1.id', 't1.title', 't1.file_path','t1.doc_type','t1.status','t1.hits', 't1.created' ) )
						 ->joinLeft ( 'da_doc AS t2', 't2.id = t1.doc_type', array ('doc_name' ) )
						 ->where('t1.id = ?', $arrParams['id'])
						 ->where ( 't1.status = 1' );
			$result = $db->fetchRow( $select );
        }
        return $result;
	}	
	
	public function hintUpdate($id = null){
		if($id) {
			$arrId = array('id'=>$id);
			$record = $this->getItem($arrId,array('task'=>'get-item'));
			$hint = $record['hits'] + 1;
			$data = array('hits'=>$hint);
            $where = 'id = (' . $id . ')';
            $this->update($data, $where);
		}			
	}
}








