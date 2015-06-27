<?php
class Default_Form_ValidateUserGroup{
    
    //CHUA NHUNG THONG BAO LOI CUA FORM
    protected $_messageError = null;
    
    //MANG CHUA DU LIEU SAU KHI KIEM TRA
    protected $_arrData;
    
    public function __construct($arrParam = array(),$options = null){
        
        //////////////////////////////////
        //Kiem tra group_name /////////////
        //////////////////////////////////
        if($arrParam['action'] == 'add'){
            $options = array('table'=>'da_user_group','field'=>'group_name');
        }elseif ($arrParam['action'] == 'edit'){
            $options = array('table'=>'da_user_group',
            				 'field'=>'group_name',
            				 'exclude' => array('field'=>'id',
												'value'=> $arrParam['id']
											   )
							);
        }
       $validator = new Zend_Validate(); 
       $validator->addValidator(new Zend_Validate_NotEmpty(),true)
                  ->addValidator(new Zend_Validate_StringLength(3,32),true)
                  ->addValidator(new Zend_Validate_Regex('#^[a-zA-Z0-9\-_\.\s]+$#'),true)
                  ->addValidator(new Zend_Validate_Db_NoRecordExists($options),true);
        
        if(!$validator->isValid($arrParam['group_name'])){
            $message = $validator->getMessages();
            $this->_messageError['group_name'] =  'Group name: ' . current($message);
            $arrParam['group_name'] = '';
        }  

        //////////////////////////////////
        //Kiem tra Avatar ///////////
        //////////////////////////////////
       $upload = new Zend_File_Transfer_Adapter_Http();
      
	   $fileInfo = $upload->getFileInfo('avatar');
	   $fileName = $fileInfo['avatar']['name'];
		
		if(!empty($fileName)){
		
			$upload->addValidator('Extension',true,array('jpg','gif','png'),'avatar');
			$upload->addValidator('Size',true,array('min'=>'2KB','max'=>'1000KB'),'avatar');
			if(!$upload->isValid('avatar')){
				$message = $upload->getMessages();
				$this->_messageError['avatar'] = 'Avatar: ' . current($message);
				
			}
		}
		
        //////////////////////////////////
        //Kiem tra ranking ///////////
        //////////////////////////////////
       $upload = new Zend_File_Transfer_Adapter_Http();
	   $fileInfo = $upload->getFileInfo('ranking');
		
		$fileName = $fileInfo['ranking']['name'];
		
		if(!empty($fileName)){
		
			$upload->addValidator('Extension',true,array('jpg','gif','png'),'ranking');
			$upload->addValidator('Size',true,array('min'=>'2KB','max'=>'1000KB'),'ranking');
			if(!$upload->isValid('ranking')){
				$message = $upload->getMessages();
				$this->_messageError['ranking'] = 'Ranking: ' . current($message);
				
			}
		}
        
        //////////////////////////////////
        //Kiem tra Admin Control Panel /////////////
        //////////////////////////////////
        if(empty($arrParam['group_acp']) || !isset($arrParam['group_acp'])){
			$arrParam['group_acp'] = 0;
		}
		
        //////////////////////////////////
        //Kiem tra Group Default /////////////
        //////////////////////////////////
        if(empty($arrParam['group_default']) || !isset($arrParam['group_default'])){
			$arrParam['group_default'] = 0;
		}
		
        //////////////////////////////////
        //Kiem tra Status /////////////
        //////////////////////////////////
        if(empty($arrParam['status']) || !isset($arrParam['status'])){
			$arrParam['status'] = 0;
		}
        
        //////////////////////////////////
        //Kiem tra order /////////////
        //////////////////////////////////   
        $validator = new Zend_Validate();
        $validator->addValidator(new Zend_Validate_Digits(),true);
        if(!$validator->isValid($arrParam['order'])){
            $message = $validator->getMessages();
            $this->_messageError['order'] = 'Order: ' . current($message);
            $arrParam['order'] = '';
        }
		//========================================
		// TRUYEN CAC GIA TRI DUNG VAO MANG $_arrData
		//========================================
		$this->_arrData = $arrParam;
        
    }
    
    //kiem tra Error
    //return true neu co loi xuat hien
    public function isError(){
        if(count($this->_messageError)>0){
            return true;
        }else{
            return false;
        }
    }
    
    //Tra ve cac thong bao loi
    public function getMessageError(){
        return $this->_messageError;
    }
    
    //Tra ve mang du lieu sau khi kiem tra
    public function getData($option = null){
       if($option['upload'] == true){
           $this->_arrData['avatar'] = $this->uploadFile('avatar');
           $this->_arrData['ranking'] = $this->uploadFile('ranking');
       }
            return $this->_arrData;
    }
    
    public function uploadFile($param){
        if(!empty($param)){
        $upload_dir = FILES_PATH . '/group/' . $param;
        
        $upload = new Zendda_File_Upload();
        $fileInfo = $upload->getFileInfo($param);
		$fileName = $fileInfo[$param]['name'];
		
		if(!empty($fileName)){
            $fileName = $upload->upload($fileName, $upload_dir . '/orignal',array('task'=>'rename'),'group_' . $param . '_');
            
            $thumb = Zendda_File_Images::create($upload_dir . '/orignal/' . $fileName);
    		$thumb->resize(100,100)->save($upload_dir . '/img100x100/' . $fileName);
    
    		$thumb = Zendda_File_Images::create($upload_dir . '/orignal/' . $fileName);
    		$thumb->resize(450,450)->save($upload_dir . '/img450x450/' . $fileName);
		    if($this->_arrData['action']=='edit'){
		        $upload->removeFile($upload_dir . '/orignal/' . $this->_arrData['current_group_' . $param]);
		        $upload->removeFile($upload_dir . '/img100x100/' . $this->_arrData['current_group_' . $param]);
		        $upload->removeFile($upload_dir . '/img450x450/' . $this->_arrData['current_group_' . $param]);
		    }
		}else{
		    if($this->_arrData['action']=='edit'){
		        $fileName = $this->_arrData['current_group_' . $param];
		    }
		}
        }
		
		return $fileName;
    }
}