<?php
class Donga_Model_QuestionAnswer extends Zend_Db_Table {
	
	protected $_name = 'da_qa';
	protected $_primary = 'qa_id';
	protected $_is_answer;
	
	public function countItem($arrParams = null, $options = null){
		if($options['task'] == 'public-qa'){
			$db = Zend_Registry::get('connectDb');
			$select = $db->select()
						 ->from('da_qa as daq',array('COUNT(daq.qa_id) AS totalItem'))
						 ->where('daq.is_answer = ?', $this->_is_answer);
			$result = $db->fetchOne($select);
		}
		return $result;
	}
	
	public function getItem($arrParams = null,$Option = null){
        if($Option['task'] == 'admin-info' || $Option['task'] == 'admin-edit'){
            $db = Zend_Registry::get('connectDb');
            
            $select = $db->select()
                         ->from('da_qa as q')
                         ->joinLeft('da_users as u', 'q.created_by = u.id',array('user_name as creater'))
                         ->where('q.qa_id = ?',$arrParams['id'],INTEGER);
                         
            $result = $db->fetchRow($select);

            $select2 = $db->select()
                          ->from('da_users as u',array('user_name as modifier'))
                          ->where('u.id = ?',$result['modified_by'],INTEGER);
            $modifier = $db->fetchRow($select2);
            $result['modifier'] = $modifier['modifier'];
        }
        
        if($Option['task'] == 'delete'){
            $where = 'qa_id = ' . $arrParams['id'];
            $result = $this->fetchRow($where)->toArray();
        }
        return $result;
    }
	
	public function listItems($arrParams = null, $options = null) {
		$db = Zend_Registry::get('connectDb');
        //$db = Zend_Db::factory($adapter,$config);
        
        $paginator = $arrParams['paginator'];
        $ssFilter = $arrParams['ssFilter'];
       
        if($options['task'] == 'admin-list'){
            $select = $db->select()
                         ->from('da_qa as daq',array('qa_id', 'title', 'question', 'answer', 'is_answer',
                         							  'status', 'fullname', 'email','created_by','created'));
        
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
				$select->where('title LIKE ?',$keywords,STRING);
			}	
			
        	if(!empty($ssFilter['status'])){
				$status = $ssFilter['status'];
				$select->where('status = ?',$status);
			}
			
        	if(!empty($ssFilter['other_id'])){
				$other_id = $ssFilter['other_id'];
				$select->where('qa_id <> ?',$other_id);
			}

			if(!empty($ssFilter['is_answer'])){
				$this->_is_answer = $ssFilter['is_answer'];
				$select->where('is_answer = ?', $ssFilter['is_answer']);
			} else {
				$this->_is_answer = 0;
				$select->where('is_answer = 0');
			}
			
            $result = $db->fetchAll($select);            
        }
        return $result;
	}
	
	public function saveItem($arrParams = null,$Option = null){
        
       if($Option['task'] == 'admin-add'){           
           $row = $this->fetchNew();
           $row->title        = $arrParams['title'];
           $row->question      = $arrParams['message'];
           $row->fullname      = $arrParams['fullname'];
           $row->email        = $arrParams['email'];        
           $row->created      = date("y-m-d h:m:s");
           
           $row->save();
        }
        
        if($Option['task'] == 'admin-edit'){
           $info = new Zendda_System_Info();
           $modified_by = $info->getMemberInfo('id');
           
           $where = 'qa_id = ' . $arrParams['id'];
           $row = $this->fetchRow($where);
           $row->answer         = $arrParams['answer'];
           $row->is_answer      = $arrParams['is_answer'];
           $row->status      = $arrParams['status']; 
           $row->modified     = date("y-m-d h:m:s");
           $row->modified_by  = $modified_by;
         
           $row->save();
        }
        
    }
    
	public function deleteItem($arrParams = null,$Option = null){
        if($Option['task'] == 'admin-delete'){          
            $where = 'qa_id = ' . $arrParams['id'];
            $this->delete($where);
        }
        
        if($Option['task'] == 'admin-multi-delete'){
            if(count($arrParams['cid'])>0){                
                $cid = implode(',',$arrParams['cid']);
                $where = 'qa_id IN (' . $cid . ')';
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
            $where = 'qa_id IN (' . $cid . ')';
            $this->update($data, $where);
        }elseif(isset($arrParams['id'])){
            if($arrParams['type'] == 1){                
                $status = 1;
            }else{
                $status = 0;                
            }
            $data = array('status'=>$status);
            $where = 'qa_id = (' . $arrParams['id'] . ')';
            $this->update($data, $where);
        }
    }
}