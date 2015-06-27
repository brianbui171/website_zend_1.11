<?php
class Default_Model_Users extends Zend_Db_Table{
    
    protected $_name = 'da_users';
    protected $_primary = 'id';
    //protected $_primary = array('id1','id2');    
    
    public function countItem($arrParams = null, $options = null){
		$db = Zend_Registry::get('connectDb');
		//$db = Zend_Db::factory($adapter,$config);
		$ssFilter = $arrParams['ssFilter'];
		$select = $db->select()
					->from('da_users AS u',array('COUNT(u.id) AS totalItem'));
		//echo $select;	
        if(!empty($ssFilter['keywords'])){
				$keywords = '%' . $ssFilter['keywords'] . '%';
				$select->where('u.user_name LIKE ?',$keywords,STRING);
		}
		
        if($ssFilter['group_id']>0){
			    $select->where('u.group_id LIKE ?',$ssFilter['group_id'],INTEGER);
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
                         ->from('da_users AS u',array('id','user_name','status','email','register_date'))
                         ->joinLeft('da_user_group AS g', 'g.id = u.group_id',array('group_name'));
        
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
				$select->where('u.user_name LIKE ?',$keywords,STRING);
			}
			
			if($ssFilter['group_id']>0){
			    $select->where('u.group_id LIKE ?',$ssFilter['group_id'],INTEGER);
			}
            $result = $db->fetchAll($select);            
        }
        return $result;
    }
    
    public function saveItem($arrParams = null,$Option = null){
        
       if($Option['task'] == 'admin-add'){
            
           $row = $this->fetchNew();
           $encode = new Zendda_Encode();
           $row->user_name         = $arrParams['user_name'];
           $row->user_avatar       = $arrParams['user_avatar'];
           $row->password          = $encode->password($arrParams['password']);
           $row->email             = $arrParams['email'];
           $row->group_id          = $arrParams['group_id'];
           $row->first_name        = $arrParams['first_name'];
           $row->last_name         = $arrParams['last_name'];
           $row->birthday         = $arrParams['birth_day'];
           $row->status            = $arrParams['status'];
           $row->sign              = $arrParams['sign'];  
           $row->register_date     = date("y-m-d"); 
           $row->register_ip       = $_SERVER['REMOTE_ADDR'];      

           $row->save();
        }
        
        if($Option['task'] == 'admin-edit'){
            echo __METHOD__;
            echo '<pre>';
            echo print_r($arrParams);
            echo '</pre>';
           $where = 'id = ' . $arrParams['id'];
           $row = $this->fetchRow($where);
           
           $encode = new Zendda_Encode();
           $row->user_name         = $arrParams['user_name'];
           $row->user_avatar       = $arrParams['user_avatar'];
           if(!empty($arrParams['password'])){
               $row->password          = $encode->password($arrParams['password']);
           }
           $row->email             = $arrParams['email'];
           $row->group_id          = $arrParams['group_id'];
           $row->first_name        = $arrParams['first_name'];
           $row->last_name         = $arrParams['last_name'];
           $row->birthday         = $arrParams['birth_day'];
           $row->status            = $arrParams['status'];
           $row->sign              = $arrParams['sign'];  
         
           $row->save();
        }
        
    }
    
    public function getItem($arrParams = null,$Option = null){
        if($Option['task'] == 'admin-info' || $Option['task'] == 'admin-edit'){
            $db = Zend_Registry::get('connectDb');
            //$db = Zend_Db::factory($adapter,$config);
            
            $select = $db->select()
                         ->from('da_users as u')
                         ->joinLeft('da_user_group as g', 'u.group_id = g.id',array('group_name'))
                         ->where('u.id = ?',$arrParams['id'],INTEGER);
                         
            $result = $db->fetchRow($select);            
        }
        
        if($Option['task'] == 'delete'){
            $where = 'id = ' . $arrParams['id'];
            $result = $this->fetchRow($where)->toArray();
        }
        return $result;
    }
    
    public function deleteItem($arrParams = null,$Option = null){
        if($Option['task'] == 'admin-delete'){
            
            //Lay thong tin user can xoa
            $row = $this->getItem($arrParams,array('task'=>'delete'));
            //Xo� hinh avatar cua user
            $upload_dir = FILES_PATH . '/users';
            $upload = new Zendda_File_Upload();
            $upload->removeFile($upload_dir . '/orignal/' . $row['user_avatar']);
		    $upload->removeFile($upload_dir . '/img100x100/' . $row['user_avatar']);
		    $upload->removeFile($upload_dir . '/img450x450/' . $row['user_avatar']);
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
                    $upload_dir = FILES_PATH . '/users';
                    $upload = new Zendda_File_Upload();
                    $upload->removeFile($upload_dir . '/orignal/' . $row['user_avatar']);
        		    $upload->removeFile($upload_dir . '/img100x100/' . $row['user_avatar']);
        		    $upload->removeFile($upload_dir . '/img450x450/' . $row['user_avatar']);
                }
                //xoa thong tin cac user khoi database
                echo '<br>' . $cid = implode(',',$arrParams['cid']);
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








