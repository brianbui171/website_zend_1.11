<?php
class Donga_Model_Album extends Zend_Db_Table {
	
	protected $_name = 'da_album';
	protected $_primary = 'id';
	
	public function countItem($arrParams = null, $options = null){
		if($options['task'] == 'count-item'){
			$db = Zend_Registry::get('connectDb');
			$select = $db->select()
						 ->from('da_album as alb',array('COUNT(alb.id) AS totalItem'));
						 
			if($arrParams['controller'] == 'album') {
				$select->where ('alb.status = 1');
			}
			
			$result = $db->fetchOne($select);
		}
		return $result;	
	}
	
	public function getListItem($arrParams = null, $options = null) {
		$db = Zend_Registry::get ( 'connectDb' );
		
		$paginator = $arrParams ['paginator'];
		$ssFilter = $arrParams['ssFilter'];
		if ($options ['task'] == 'list-item') {
			$select = $db->select ()
						 ->from ('da_album');
						 
			
			if($arrParams['controller'] == 'album') {
				$select->where ('status = 1');
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
				$select->where('album_name LIKE ?',$keywords,STRING);
			}
			
			$result = $db->fetchAll ( $select );
		}
		return $result;
	}
	
	public function getItem($arrParams = null, $options = null) {
		$db = Zend_Registry::get ( 'connectDb' );		
		if($options['task'] == 'admin-info'){
            $select = $db->select ()
						 ->from ( 'da_album')
						 ->where('id = ?', $arrParams['id']);
			$result = $db->fetchRow( $select );
        }
        
		if($options['task'] == 'delete'){
            $where = 'id = ' . $arrParams['id'];
            $result = $this->fetchRow($where)->toArray();
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
            
            //Lay thong tin user can xoa
            $row = $this->getItem($arrParams,array('task'=>'delete'));
            //Xo� hinh avatar cua user
            $upload_dir = FILES_PATH . '/photo/album';
            $upload = new Zendda_File_Upload();
            $upload->removeFile($upload_dir . '/' . $row['image']);
            //xo� thong tin user khoi database
            $where = 'id = ' . $arrParams['id'];
            $this->delete($where);
        }
        
        if($Option['task'] == 'admin-multi-delete'){
            if(count($arrParams['cid'])>0){
                foreach($arrParams['cid'] as $key){                
                    $arrParams['id'] = $key;
                  
                    //Lay thong tin user can xoa
                    $row = $this->getItem($arrParams,array('task'=>'delete'));
                    //Xo� hinh avatar cua user
                    $upload_dir = FILES_PATH . '/photo/album';
                    $upload = new Zendda_File_Upload();
                    $upload->removeFile($upload_dir . '/' . $row['image']);
                }
                //xoa thong tin cac user khoi database
                echo '<br>' . $cid = implode(',',$arrParams['cid']);
                $where = 'id IN (' . $cid . ')';
                $this->delete($where);
            }
        }
    }
    
	public function saveItem($arrParams = null,$Option = null){
        
       if($Option['task'] == 'admin-add'){
           $info = new Zendda_System_Info();
           $created_by = $info->getMemberInfo('id');
           $row = $this->fetchNew();
           $row->album_name         = $arrParams['album_name'];
           $row->image      = $arrParams['picture'];
           $row->status        = $arrParams['status'];
           $row->order        = $arrParams['order'];         
           $row->created      = date("y-m-d h:m:s");
           $row->created_by      = $created_by;
           
           $row->save();
        }
        
        if($Option['task'] == 'admin-edit'){
           $info = new Zendda_System_Info();
           $modified_by = $info->getMemberInfo('id');
           
           $where = 'id = ' . $arrParams['id'];
           $row = $this->fetchRow($where);
           $row->album_name   = $arrParams['album_name'];
           $row->image      = $arrParams['picture'];
           $row->status        = $arrParams['status'];
           $row->order        = $arrParams['order'];         
           $row->created      = date("y-m-d h:m:s");
           $row->created_by      = $modified_by;
         
           $row->save();
        }
        
    }
}