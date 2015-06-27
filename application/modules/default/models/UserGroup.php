<?php
class Default_Model_UserGroup extends Zend_Db_Table{
    
    protected $_name = 'da_user_group';
    protected $_primary = 'id';
    //protected $_primary = array('id1','id2');
    
    public function itemInSelectbox($arrParams = null, $options = null){
        $db = Zend_Registry::get('connectDb');
		//$db = Zend_Db::factory($adapter,$config);
        
        if($options == null){
            $select = $db->select()
                         ->from('da_user_group AS g',array('id','group_name'));
            $result = $db->fetchPairs($select);
            $result[0] = ' -- Select an item -- ';
            ksort($result);         
        }
        
        return $result;
    }
    
    public function countItem($arrParams = null, $options = null){
		$db = Zend_Registry::get('connectDb');
		//$db = Zend_Db::factory($adapter,$config);
		$ssFilter = $arrParams['ssFilter'];
		$select = $db->select()
					->from('da_user_group AS g',array('COUNT(g.id) AS totalItem'));
		//echo $select;	
        if(!empty($ssFilter['keywords'])){
				$keywords = '%' . $ssFilter['keywords'] . '%';
				$select->where('g.group_name LIKE ?',$keywords,STRING);
		}
		$result = $db->fetchOne($select);
		return $result;
		
	}
    
    public function sortItem($arrParams = null,$Option = null){
        if($Option['task'] == 'admin-sort'){
            
            if(count($arrParams['cid'])>0){
                $cid = $arrParams['cid'];
                $order = $arrParams['order'];
                foreach ($cid as $key=>$val){
                    $data = array('order'=>$order[$val]);
                    $where = 'id = ' . $val;
                    $this->update($data, $where);
                }
            }
        }
    }
    
    public function listItems($arrParams = null,$Option = null){
        
        $db = Zend_Registry::get('connectDb');
        //$db = Zend_Db::factory($adapter,$config);
        
        $paginator = $arrParams['paginator'];
        $ssFilter = $arrParams['ssFilter'];
        
        if($Option['task'] == 'admin-list'){
            $select = $db->select()
                         ->from('da_user_group AS g',array('g.id','g.group_name','g.group_acp','g.status','g.order'))
                         ->joinLeft('da_users AS u', 'g.id = u.group_id','COUNT(u.id) AS members')
                         ->group('g.id');
        
            if(!empty($ssFilter['col']) && !empty($ssFilter['order'])){
				$select->order($ssFilter['col'] . ' ' . $ssFilter['order']);
			
			}
			             
            if($paginator['itemCountPerPage']>0){
				$page = $paginator['currentPage'];
				$rowCount = $paginator['itemCountPerPage'];
				$select->limitPage($page,$rowCount);
			}
           
            if(!empty($ssFilter['keywords'])){
				$keywords = '%' . $ssFilter['keywords'] . '%';
				$select->where('g.group_name LIKE ?',$keywords,STRING);
			}
            $result = $db->fetchAll($select);            
        }
        return $result;
    }
    
    public function saveItem($arrParams = null,$Option = null){
        if($Option['task'] == 'admin-add'){
            
           $row = $this->fetchNew();
           
           $row->group_name     = $arrParams['group_name'];
           $row->avatar         = $arrParams['avatar'];
           $row->ranking        = $arrParams['ranking'];
           $row->group_acp      = $arrParams['group_acp'];
           $row->group_default  = $arrParams['group_default'];
           $row->created        = date("y-m-d h:m:s");
           $row->create_by      = 1;
           $row->status         = $arrParams['status'];
           $row->order          = $arrParams['order'];      

           $row->save();
        }
        
        if($Option['task'] == 'admin-edit'){
           $where = 'id = ' . $arrParams['id'];
           $row = $this->fetchRow($where);
           
           $row->group_name     = $arrParams['group_name'];
           $row->avatar         = $arrParams['avatar'];
           $row->ranking        = $arrParams['ranking'];
           $row->group_acp      = $arrParams['group_acp'];
           $row->group_default  = $arrParams['group_default'];
           $row->modified       = date("y-m-d h:m:s");
           $row->modified_by       = 1;
           $row->status         = $arrParams['status'];
           $row->order          = $arrParams['order'];      

           $row->save();
        }
        
    }
    
    public function getItem($arrParams = null,$Option = null){
        if($Option['task'] == 'admin-info' || $Option['task'] == 'admin-edit'){
            $where = 'id = ' . $arrParams['id'];
            $result = $this->fetchRow($where)->toArray();            
        }
        
        if($Option['task'] == 'delete-item'){
            $where = 'id = ' . $arrParams['id'];
            $result = $this->fetchRow($where)->toArray();
        }
        return $result;
    }
    
    public function deleteItem($arrParams = null,$Option = null){
        if($Option['task'] == 'admin-delete'){
            //Lay thong tin can xoa hinh           
            $row = $this->getItem($arrParams,array('task'=>'delete-item'));
            $upload_dir = FILES_PATH . '/group';
            $upload = new Zendda_File_Upload();
            //Xoa hinh avatar cua group
            $upload->removeFile($upload_dir . '/avatar/orignal/' . $row['avatar']);
		    $upload->removeFile($upload_dir . '/avatar/img100x100/' . $row['avatar']);
		    $upload->removeFile($upload_dir . '/avatar/img450x450/' . $row['avatar']);
		    //Xoa hinh ranking cua group
            $upload->removeFile($upload_dir . '/ranking/orignal/' . $row['ranking']);
		    $upload->removeFile($upload_dir . '/ranking/img100x100/' . $row['ranking']);
		    $upload->removeFile($upload_dir . '/ranking/img450x450/' . $row['ranking']);
            //Xoa group khoi database
            $where = 'id = ' . $arrParams['id'];
            $this->delete($where);
        }
        
        if($Option['task'] == 'admin-multi-delete'){
            if(count($arrParams['cid'])>0){
              
                foreach ($arrParams['cid'] as $key){
                    $arrParams['id'] = $key;
                    $row = $this->getItem($arrParams,array('task'=>'delete-item'));
                    $upload_dir = FILES_PATH . '/group';
                    $upload = new Zendda_File_Upload();
                    //Xoa hinh avatar cua group
                    $upload->removeFile($upload_dir . '/avatar/orignal/' . $row['avatar']);
        		    $upload->removeFile($upload_dir . '/avatar/img100x100/' . $row['avatar']);
        		    $upload->removeFile($upload_dir . '/avatar/img450x450/' . $row['avatar']);
        		    //Xoa hinh ranking cua group
                    $upload->removeFile($upload_dir . '/ranking/orignal/' . $row['ranking']);
        		    $upload->removeFile($upload_dir . '/ranking/img100x100/' . $row['ranking']);
        		    $upload->removeFile($upload_dir . '/ranking/img450x450/' . $row['ranking']);
                }
                $cid = implode(',',$arrParams['cid']);
                $where = 'id IN (' . $cid . ')';
                $this->delete($where);
            }
        }
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
}








