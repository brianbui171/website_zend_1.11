<?php
class Donga_Model_Doc extends Zend_Db_Table {
	
	protected $_name = 'da_doc';
	protected $_primary = 'id';
	
	public function countItem($arrParams = null, $options = null){
		if($options['task'] == 'count-item'){
			$db = Zend_Registry::get('connectDb');
			$select = $db->select()
						 ->from('da_doc as dad',array('COUNT(dad.id) AS totalItem'));
						 
			if($arrParams['controller'] == 'doc') {
				$select->where ('dad.status = 1');
			}
			
			$result = $db->fetchOne($select);
		}
		
		if($options['task'] == 'count-item-dtl'){
			$db = Zend_Registry::get('connectDb');
			$select = $db->select()
						 ->from('da_doc_dtl as t1',array('COUNT(t1.id) AS totalItem'));
						 
			if($arrParams['controller'] == 'doc') {
				$select->where ('t1.status = 1');
				$select->where('t1.doc_type = ?', $arrParams['id']);
			}
			
			$result = $db->fetchOne($select);
		}
		
		return $result;	
	}
	
	public function getListItem($arrParams = null, $options = null) {
		$db = Zend_Registry::get ( 'connectDb' );
		//$db = Zend_Db::factory($adapter,$config);
		
		$paginator = $arrParams ['paginator'];
		$ssFilter = $arrParams['ssFilter'];
		if ($options ['task'] == 'list-item') {
			$select = $db->select ()
						 ->from ('da_doc as t1',array('t1.id','t1.doc_name','t1.status','t1.created'));
			
			if($arrParams['controller'] == 'doc') {
				$select->joinInner('da_doc_dtl as t2', 't1.id = t2.doc_type',array('COUNT(*) AS soluong'));
				$select->where ('t1.status = 1');
				$select->group(array('t1.id','t1.doc_name','t1.status','t1.created'));
				$select->having('COUNT(t1.id)>0');
			}
			if(!empty($ssFilter['col']) && !empty($ssFilter['order'])){
				$select->order($ssFilter['col'] . ' ' . $ssFilter['order']);
			}
						 
			if ($paginator ['itemCountPerPage'] > 0) {
				$page = $paginator ['currentPage'];
				$rowCount = $paginator ['itemCountPerPage'];
				$select->limitPage ( $page, $rowCount );
			}
	
			if(!empty($ssFilter['keywords'])){
				$keywords = '%' . $ssFilter['keywords'] . '%';
				$select->where('t1.doc_name LIKE ?',$keywords,STRING);
			}
			 //echo $select;
			$result = $db->fetchAll ( $select );
		}
		return $result;
	}
	
	public function getListItemDtl($arrParams = null, $options = null) {
		$db = Zend_Registry::get ( 'connectDb' );
		
		$paginator = $arrParams ['paginator'];
		$ssFilter = $arrParams['ssFilter'];
		if ($options ['task'] == 'list-item') {
			$select = $db->select ()
						 ->from ('da_doc_dtl as t1',array('t1.id','t1.title','t1.file_path','t1.status','t1.doc_type','t1.hits','t1.order','t1.created'));
			
			if($arrParams['controller'] == 'doc') {
				$select->joinInner('da_doc as t2', 't2.id = t1.doc_type',array('t2.doc_name'));
				$select->where('t1.doc_type = ?', $arrParams['id']);
				$select->where ('t1.status = 1');
			}
			if(!empty($ssFilter['col']) && !empty($ssFilter['order'])){
				$select->order($ssFilter['col'] . ' ' . $ssFilter['order']);
			}
						 
			if ($paginator ['itemCountPerPage'] > 0) {
				$page = $paginator ['currentPage'];
				$rowCount = $paginator ['itemCountPerPage'];
				$select->limitPage ( $page, $rowCount );
			}
	
			if(!empty($ssFilter['keywords'])){
				$keywords = '%' . $ssFilter['keywords'] . '%';
				$select->where('t1.title LIKE ?',$keywords,STRING);
			}
			$result = $db->fetchAll ( $select );
		}
		return $result;
	}
	
	public function getItem($arrParams = null, $options = null) {
		$db = Zend_Registry::get ( 'connectDb' );		
		if($options['task'] == 'admin-info'){
            $select = $db->select ()
						 ->from ( 'da_doc')
						 ->where('id = ?', $arrParams['id']);
			$result = $db->fetchRow( $select );
        }
        return $result;
	}
	
	public function changeStatus($arrParams = null,$Option = null){
        if(count($arrParams['cid'])>0){
            $cid = implode(',', $arrParams['cid']);
            if($arrParams['type'] == 1){                
                $status = 1;
            }else{
                $status = 0;                
            }
            $data = array('status'=>$status);
            $where = 'id IN (' . $cid . ')';
            $this->update($data, $where);
        }elseif(isset($arrParams['id'])){
            if($arrParams['type'] == 1){                
                $status = 1;
            }else{
                $status = 0;                
            }
            $data = array('status'=>$status);
            $where = 'id = (' . $arrParams['id'] . ')';
            $this->update($data, $where);
        }
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
}