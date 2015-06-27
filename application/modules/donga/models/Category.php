<?php
class Donga_Model_Category extends Zend_Db_Table {
	
	protected $_name = 'da_category';
	protected $_primary = 'category_id';
	
	public function getItem($arrParams = null,$Option = null){
		if($Option['task'] == 'get-item'){
            $where = 'category_id = ' . $arrParams['ssFilter'] ['cat_id'];
            $result = $this->fetchRow($where)->toArray();
        }
        
        if($Option['task'] == 'admin-info' || $Option['task'] == 'admin-edit'){
            $where = 'category_id = ' . $arrParams['id'];
            $result = $this->fetchRow($where)->toArray();  
           
        }
        
        if($Option['task'] == 'delete-item'){
            $where = 'category_id = ' . $arrParams['id'];
            $result = $this->fetchRow($where)->toArray();
        }
        return $result;
    }
    
	public function itemInSelectbox($arrParams = null, $options = null){
        $db = Zend_Registry::get('connectDb');
        
        if($options == null){
            $select = $db->select()
                         ->from('da_category AS pc',array('pc.category_id','pc.category_name','pc.status','pc.parents','pc.order','pc.created_by'))
                         ->where('status = 1')
                         ->order('pc.order ASC');
            
            $result = $db->fetchAll($select); 
        }
        
        if($options['task'] == 'admin-edit'){
            $select = $db->select()
                         ->from('da_category AS pc',array('pc.category_id','pc.category_name','pc.status','pc.parents','pc.order','pc.created_by'))
                         ->where('category_id != ?',$arrParams['id'],INTEGER)
                         ->order('pc.order ASC');
            $result = $db->fetchAll($select); 
        }
        
        $system = new Zendda_System_Recursive($result);  
            $result = $system->buildArray(0);       
            $tmp = array('category_id'=>0,'category_name'=>'Root category','level'=>1,'parents'=>0,'order'=>1);
            array_unshift($result, $tmp);
        
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
                    $where = 'category_id = ' . $val;
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
                         ->from('da_category AS pc',array('pc.category_id','pc.category_name','pc.status','pc.parents','pc.order','pc.created_by'))
                         ->joinLeft('da_users AS u', 'u.id = pc.created_by',array('user_name'))
                         ->order('pc.order ASC');
            
            /*if(!empty($ssFilter['keywords'])){
				$keywords = '%' . $ssFilter['keywords'] . '%';
				$select->where('g.group_name LIKE ?',$keywords,STRING);
			}*/
            $result = $db->fetchAll($select); 
            $system = new Zendda_System_Recursive($result);  
            $result = $system->buildArray(0);         
        }
        return $result;
    }
    
    public function saveItem($arrParams = null,$Option = null){
        if($Option['task'] == 'admin-add'){
           $info = new Zendda_System_Info();
           $created_by = $info->getMemberInfo('id');
           $row = $this->fetchNew();           
           
           $row->category_name	= $arrParams['name'];
           $row->picture      	= $arrParams['picture'];
           $row->status       	= $arrParams['status'];
           $row->parents      	= $arrParams['parents'];
           $row->order        	= $arrParams['order'];
           $row->created      	= date("y-m-d h:m:s");
           $row->created_by   	= $created_by;   
           
           $row->save();
        }
        
        if($Option['task'] == 'admin-edit'){
           $info = new Zendda_System_Info();
           $modified_by = $info->getMemberInfo('id');
           
           $where = 'category_id = ' . $arrParams['id'];
           $row = $this->fetchRow($where);
           
           $row->category_name	= $arrParams['name'];
           $row->picture      	= $arrParams['picture'];
           $row->status       	= $arrParams['status'];
           $row->parents      	= $arrParams['parents'];
           $row->order        = $arrParams['order'];
           $row->modified       = date("y-m-d h:m:s");
           $row->modified_by    = $modified_by;

           $row->save();
        }
        
    }
    
    public function deleteItem($arrParams = null,$Option = null){
        if($Option['task'] == 'admin-delete'){
            $db = Zend_Registry::get('connectDb');
            $id = $arrParams['id'];
            $select = $db->select()
                         ->from('da_category AS pc',array('pc.category_id','pc.category_name','pc.status','pc.parents','pc.order','pc.created_by'));
            $result = $db->fetchAll($select); 
            $system = new Zendda_System_Recursive($result);  
            $result = $system->buildArray($id); 
            array_unshift($result,array('id'=>$id));

            foreach($result as $key => $value){
                $where = 'category_id = (' . $value['id'] . ')';
                $this->delete($where);
            }
        }
        
        if($Option['task'] == 'admin-multi-delete'){
            $cid = $arrParams['cid'];
			if(count($cid)>0){
				
				$db = Zend_Registry::get('connectDb');
				$id = $arrParams['id'];
				$select = $db->select()
						 	  ->from('da_category AS pc',array('category_id','category_name','status','parents','order','created_by'));
				$result  = $db->fetchAll($select);		
				
				$newArray = array();
				foreach ($cid as $key => $val){
					$id = $val;
					$newArray[] = array('id'=>$id);
					$system = new Zendda_System_Recursive($result);		
					$tmp = $system->buildArray($id);
					foreach ($tmp as $keyTmp => $valTmp){
						$newArray[] = $valTmp;
					}
				}
				
				if(count($newArray)>0){
					foreach($newArray as $keyNew => $valNew){				
						$where = ' category_id = ' . $valNew['id'];
						$this->delete($where);
					}
				}
			}
        }
    }
    
    public function changestatus($arrParams = null,$Option = null){
        if(count($arrParams['cid'])>0){
            $cid = implode(',', $arrParams['cid']);
            if($arrParams['type'] == 1){                
                $status = 1;
            }else{
                $status = 0;                
            }
            $data = array('status'=>$status);
            $where = 'category_id IN (' . $cid . ')';
            $this->update($data, $where);
        }elseif(isset($arrParams['id'])){
            if($arrParams['type'] == 1){                
                $status = 1;
            }else{
                $status = 0;                
            }
            $data = array('status'=>$status);
            $where = 'category_id = (' . $arrParams['id'] . ')';
            $this->update($data, $where);
        }
    }
}