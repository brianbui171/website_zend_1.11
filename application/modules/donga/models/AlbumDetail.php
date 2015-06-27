<?php
class Donga_Model_AlbumDetail extends Zend_Db_Table {
	
	protected $_name = 'da_album_dtl';
	protected $_primary = 'id';
	protected $_album;
	
	public function countItem($arrParams = null, $options = null){
		if($options['task'] == 'count-item'){
			$db = Zend_Registry::get('connectDb');
			$select = $db->select()
						 ->from('da_album_dtl as alb',array('COUNT(alb.id) AS totalItem'))
						 ->where('alb.status = 1')
						 ->where('alb.album_id = ?', $this->_album);
			$result = $db->fetchOne($select);
		}
		return $result;	
	}
	
	public function getListItem($arrParams = null, $options = null) {
		$db = Zend_Registry::get ( 'connectDb' );
		
		$this->_album = $arrParams['album_id'];
		$paginator = $arrParams ['paginator'];
		
		if ($options ['task'] == 'list-item') {
			$select = $db->select ()
						 ->from ('da_album_dtl as adtl')
						 ->joinLeft ( 'da_album as alb', 'adtl.album_id = alb.id', array ('album_name' ) )
						 ->where ('adtl.status = 1')
						 ->where('adtl.album_id = ?', $this->_album);
			
			if ($paginator ['itemCountPerPage'] > 0) {
				$page = $paginator ['currentPage'];
				$rowCount = $paginator ['itemCountPerPage'];
				$select->limitPage ( $page, $rowCount );
			}
	
			$select->order('adtl.created DESC');
			
			$result = $db->fetchAll ( $select );
		}
		return $result;
	}
	
	public function deleteItem($arrParams = null,$Option = null){
        if($Option['task'] == 'admin-delete'){       
        	//Lay thong tin user can xoa
            $row = $this->getItem($arrParams,array('task'=>'delete'));
            //Xo� hinh avatar cua user
            $upload_dir = FILES_PATH . '/photo/album-dtl';
            $upload = new Zendda_File_Upload();
            $upload->removeFile($upload_dir . '/' . $row['image_actual']);
		    $upload->removeFile($upload_dir . '/thumbnails/' . $row['image_thumb']);
		       
            $where = 'id = ' . $arrParams['id'];
            $result = $this->delete($where);
        }
        
        if($Option['task'] == 'admin-multi-delete'){ 
        	if(count($arrParams['cid'])>0){
                foreach($arrParams['cid'] as $key){                
                    $arrParams['id'] = $key;
                  
                    //Lay thong tin user can xoa
                    $row = $this->getItem($arrParams,array('task'=>'delete'));
                    //Xo� hinh avatar cua user
                    $upload_dir = FILES_PATH . '/photo/album-dtl';
                    $upload = new Zendda_File_Upload();
                    $upload->removeFile($upload_dir . '/' . $row['image_actual']);
		    		$upload->removeFile($upload_dir . '/thumbnails/' . $row['image_thumb']);
                }
                //xoa thong tin cac user khoi database
                $cid = implode(',',$arrParams['cid']);
                $where = 'id IN (' . $cid . ')';
                $result = $this->delete($where);
            }
        }
        return $result;
    }
	
	public function getItem($arrParams = null, $options = null) {
		$db = Zend_Registry::get ( 'connectDb' );		
		if($options['task'] == 'get-item'){
            $select = $db->select ()
						 ->from ( 'da_album_dtl AS t1')
						 ->joinLeft ( 'da_album AS t2', 't1.album_id = t2.id', array ('album_name'))
						 ->where('t1.id = ?', $arrParams['id'])
						 ->where('t1.status = 1');
						 
			$result = $db->fetchRow( $select );
        }
        
		if($options['task'] == 'delete'){
            $where = 'id = ' . $arrParams['id'];
            $result = $this->fetchRow($where)->toArray();
        }
        return $result;
	}
	
	public function saveItem($arrParams = null,$Option = null){
        
       if($Option['task'] == 'admin-add'){
           $info = new Zendda_System_Info();
           $created_by = $info->getMemberInfo('id');
           $row = $this->fetchNew();
           $row->title         = $arrParams['title'];
           $row->image_thumb      = $arrParams['image_name'];
           $row->image_actual        = $arrParams['image_name'];
           $row->status        = 1;     
           $row->album_id =    $arrParams['album_id'];
           $row->created      = date("y-m-d h:m:s");
           $row->created_by      = $created_by;
           
           $row->save();
        }        
    }
}