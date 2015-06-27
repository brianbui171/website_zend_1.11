<?php
class Donga_Model_Item extends Zend_Db_Table{
    
    protected $_name = 'da_news';
    protected $_primary = 'news_id'; 
    
    public function countItem($arrParams = null, $options = null){
		$db = Zend_Registry::get('connectDb');
		$ssFilter = $arrParams['ssFilter'];
		$select = $db->select()
					->from('da_news AS ns',array('COUNT(ns.news_id) AS totalItem'));
		//echo $select;	
        if(!empty($ssFilter['keywords'])){
				$keywords = '%' . $ssFilter['keywords'] . '%';
				$select->where('ns.title_news LIKE ?',$keywords,STRING);
		}
		
        if($ssFilter['cat_id']>0){
			    $select->where('ns.news_type LIKE ?',$ssFilter['cat_id'],INTEGER);
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
                    $where = 'news_id = ' . $val;
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
                         ->from('da_news AS ns',array('news_id', 'title_news', 'status', 'img_news_sml', 'img_news_big',
                         							  'news_hot', 'hits', 'created','created_by','order'))
                         ->joinLeft('da_users AS dau', 'dau.id = ns.created_by',array('user_name as author'))
                         ->joinLeft('da_category AS dac', 'dac.category_id = ns.news_type',array('category_name'));
        
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
				$select->where('ns.title_news LIKE ?',$keywords,STRING);
			}
			
			if($ssFilter['cat_id']>0){
			    $select2 = $db->select()
                         ->from('da_category AS dac',array('dac.category_id','dac.category_name','dac.status','dac.PARENTS','dac.order','dac.created_by'));
                $result2 = $db->fetchAll($select2); 
                $system = new Zendda_System_Recursive($result2);  
                $result2 = $system->buildArray($ssFilter['cat_id']); 
              if(count($result2)>1){
                    array_unshift($result2,array('category_id'=>$ssFilter['cat_id']));
                    $ids = '(';
                    $i = 0;
                    foreach ($result2 as $key => $value){
                        if($i == count($result2) - 1){
    			            $ids .= $value['category_id'] . ')';
                        }else{
                            $ids .= $value['category_id'] . ',';
                        }
                        $i++;
                    }
                    $select->where('ns.news_type IN ' . $ids);
               }else {
                   $select->where('ns.news_type = ? ', $ssFilter['cat_id'],INTEGER);
               }
			}
            $result = $db->fetchAll($select);            
        }
        return $result;
    }
    
    public function saveItem($arrParams = null,$Option = null){
        
       if($Option['task'] == 'admin-add'){
           $info = new Zendda_System_Info();
           $created_by = $info->getMemberInfo('id');
           $row = $this->fetchNew();
           $row->title_news         = $arrParams['name'];
           $row->img_news_sml      = $arrParams['picture'];
           $row->img_news_big      = $arrParams['picture'];
           $row->news_hot        = $arrParams['newshot'];
           $row->news_type       = $arrParams['cat_id'];
           $row->status       = $arrParams['status'];
           $row->order        = $arrParams['order'];
           $row->summary_news     = $arrParams['synopsis'];
           $row->content_news      = $arrParams['content'];           
           $row->created      = date("y-m-d h:m:s");
           $row->created_by      = $created_by;
           
           $row->save();
        }
        
        if($Option['task'] == 'admin-edit'){
           $info = new Zendda_System_Info();
           $modified_by = $info->getMemberInfo('id');
           
           $where = 'news_id = ' . $arrParams['id'];
           $row = $this->fetchRow($where);
           $row->title_news         = $arrParams['name'];
           $row->img_news_sml      = $arrParams['picture'];
           $row->img_news_big      = $arrParams['picture'];
           $row->news_hot        = $arrParams['newshot'];
           $row->news_type       = $arrParams['cat_id'];
           $row->status       = $arrParams['status'];
           $row->order        = $arrParams['order'];
           $row->summary_news     = $arrParams['synopsis'];
           $row->content_news      = $arrParams['content'];  
           $row->modified     = date("y-m-d h:m:s");
           $row->modified_by  = $modified_by;
         
           $row->save();
        }
        
    }
    
    public function getItem($arrParams = null,$Option = null){
        if($Option['task'] == 'admin-info' || $Option['task'] == 'admin-edit'){
            $db = Zend_Registry::get('connectDb');
            //$db = Zend_Db::factory($adapter,$config);
            
            $select = $db->select()
                         ->from('da_news as ns')
                         ->joinLeft('da_category as dac', 'ns.news_type = dac.category_id',array('category_name as category'))
                         ->joinLeft('da_users as u', 'ns.created_by = u.id',array('user_name as creater'))
                         ->where('ns.news_id = ?',$arrParams['id'],INTEGER);
                         
            $result = $db->fetchRow($select);

            $select2 = $db->select()
                          ->from('da_users as u',array('user_name as modifier'))
                          ->where('u.id = ?',$result['modified_by'],INTEGER);
            $modifier = $db->fetchRow($select2);
            $result['modifier'] = $modifier['modifier'];
        }
        
        if($Option['task'] == 'delete'){
            $where = 'news_id = ' . $arrParams['id'];
            $result = $this->fetchRow($where)->toArray();
        }
        return $result;
    }
    
    public function deleteItem($arrParams = null,$Option = null){
        if($Option['task'] == 'admin-delete'){
            
            //Lay thong tin user can xoa
            $row = $this->getItem($arrParams,array('task'=>'delete'));
            //Xo� hinh avatar cua user
            $upload_dir = FILES_PATH . '/news';
            $upload = new Zendda_File_Upload();
            $upload->removeFile($upload_dir . '/orignal/' . $row['img_news_big']);
		    $upload->removeFile($upload_dir . '/img_big/' . $row['img_news_big']);
		    $upload->removeFile($upload_dir . '/img_small/' . $row['img_news_big']);
            //xo� thong tin user khoi database
            $where = 'news_id = ' . $arrParams['id'];
            $this->delete($where);
        }
        
        if($Option['task'] == 'admin-multi-delete'){
            if(count($arrParams['cid'])>0){
                foreach($arrParams['cid'] as $key){                
                    $arrParams['id'] = $key;
                  
                    //Lay thong tin user can xoa
                    $row = $this->getItem($arrParams,array('task'=>'delete'));
                    //Xo� hinh avatar cua user
                    $upload_dir = FILES_PATH . '/news';
                    $upload = new Zendda_File_Upload();
                    $upload->removeFile($upload_dir . '/img_big/' . $row['img_news_big']);
        		    $upload->removeFile($upload_dir . '/img_small/' . $row['img_news_big']);
        		    $upload->removeFile($upload_dir . '/orignal/' . $row['img_news_big']);
                }
                //xoa thong tin cac user khoi database
                echo '<br>' . $cid = implode(',',$arrParams['cid']);
                $where = 'news_id IN (' . $cid . ')';
                $this->delete($where);
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
            $where = 'news_id IN (' . $cid . ')';
            $this->update($data, $where);
        }elseif(isset($arrParams['id'])){
            if($arrParams['type'] == 1){                
                $status = 1;
            }else{
                $status = 0;
            }
            $data = array('status'=>$status);
            $where = 'news_id = (' . $arrParams['id'] . ')';
            $this->update($data, $where);
        }
    }
}








