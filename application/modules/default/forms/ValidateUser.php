<?php
class Default_Form_ValidateUser{
    
    //CHUA NHUNG THONG BAO LOI CUA FORM
    protected $_messageError = null;
    
    //MANG CHUA DU LIEU SAU KHI KIEM TRA
    protected $_arrData;
    
    public function __construct($arrParam = array(),$options = null){
        
        //////////////////////////////////
        //Kiem tra User Name /////////////
        //////////////////////////////////
        if($arrParam['action'] == 'add'){
            $options = array('table'=>'da_users','field'=>'user_name');
        }elseif ($arrParam['action'] == 'edit'){
            $options = array('table'=>'da_users',
            				 'field'=>'user_name',
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
        
        if(!$validator->isValid($arrParam['user_name'])){
            $message = $validator->getMessages();
            $this->_messageError['user_name'] =  'User name: ' . current($message);
            $arrParam['user_name'] = '';
        }  

        //////////////////////////////////
        //Kiem tra User Avatar ///////////
        //////////////////////////////////
       $upload = new Zend_File_Transfer_Adapter_Http();
	   $fileInfo = $upload->getFileInfo('user_avatar');
		
		$fileName = $fileInfo['user_avatar']['name'];
		
		if(!empty($fileName)){
		
			$upload->addValidator('Extension',true,array('jpg','gif','png'),'user_avatar');
			$upload->addValidator('Size',true,array('min'=>'2KB','max'=>'1000KB'),'user_avatar');
			if(!$upload->isValid('user_avatar')){
				$message = $upload->getMessages();
				$this->_messageError['user_avatar'] = 'Avatar: ' . current($message);
				
			}
		}
       
        //////////////////////////////////
        //Kiem tra Password /////////////
        //////////////////////////////////
        $flag = false;
        if($arrParam['action'] == 'add'){
            $flag = true;
        }elseif ($arrParam['action'] == 'edit'){
            if(empty($arrParam['password'])){
                $flag = false;
            }else {
                $flag = true;
            }            
        }
        
        if($flag == true){
        $validator = new Zend_Validate();   
        $validator->addValidator(new Zend_Validate_NotEmpty(),true)
                  ->addValidator(new Zend_Validate_StringLength(3,32),true)
                  ->addValidator(new Zend_Validate_Regex('#^[a-zA-Z0-9@\#\$%\^&\*\-\+]+$#'),true);
        
        if(!$validator->isValid($arrParam['password'])){
            $message = $validator->getMessages();
            $this->_messageError['password'] =  'Password: ' . current($message);
        } 
        }
        
        //////////////////////////////////
        //Kiem tra Email ////////////////
        //////////////////////////////////        
        if($arrParam['action'] == 'add'){
            $options = array('table'=>'da_users','field'=>'email');
        }elseif ($arrParam['action'] == 'edit'){
            $options = array('table'=>'da_users',
            				 'field'=>'email',
            				 'exclude' => array('field'=>'id',
												'value'=> $arrParam['id']
											   )
							);
        }
        $validator = new Zend_Validate();        
        $validator->addValidator(new Zend_Validate_NotEmpty(),true)
                  ->addValidator(new Zend_Validate_EmailAddress(),true)
                  ->addValidator(new Zend_Validate_Db_NoRecordExists($options),true);
                  
        if(!$validator->isValid($arrParam['email'])){
            $message = $validator->getMessages();
            $this->_messageError['email'] = 'Email: ' . current($message);
            $arrParam['email'] = '';
        }
        
        //////////////////////////////////
        //Kiem tra Group Name ////////////
        //////////////////////////////////
        if($arrParam['group_id'] == 0){
            $this->_messageError['group_id'] = 'Group Name: Please choose Group Name';
        }
        
        //////////////////////////////////
        //Kiem tra First Name /////////////
        //////////////////////////////////
        $validator = new Zend_Validate();
        $validator->addValidator(new Zend_Validate_NotEmpty(),true)
                  ->addValidator(new Zend_Validate_StringLength(2),true);
        if(!$validator->isValid($arrParam['first_name'])){
            $message = $validator->getMessages();
            $this->_messageError['first_name'] = 'First Name: ' . current($message);
            $arrParam['first_name'] = '';
        }
        
        //////////////////////////////////
        //Kiem tra Last Name /////////////
        //////////////////////////////////
        $validator = new Zend_Validate();
        $validator->addValidator(new Zend_Validate_NotEmpty(),true)
                  ->addValidator(new Zend_Validate_StringLength(2),true);
        if(!$validator->isValid($arrParam['last_name'])){
            $message = $validator->getMessages();
            $this->_messageError['last_name'] = 'Last Name: ' . current($message);
            $arrParam['last_name'] = '';
        }
        
        //////////////////////////////////
        //Kiem tra Birthday /////////////
        //////////////////////////////////
        $validator = new Zend_Validate();
        $validator->addValidator(new Zend_Validate_NotEmpty(),true)
                  ->addValidator(new Zend_Validate_Date(array('format'=>'YYYY-mm-dd')),true);
                  
        if(!$validator->isValid($arrParam['birth_day'])){
            $message = $validator->getMessages();
            $this->_messageError['birth_day'] = 'Birthday: ' . current($message);
            $arrParam['birth_day'] = '';
        }
        
        //////////////////////////////////
        //Kiem tra Status /////////////
        //////////////////////////////////
        if(empty($arrParam['status']) || !isset($arrParam['status'])){
			$arrParam['status'] = 0;
		}
        
        //////////////////////////////////
        //Kiem tra Sign /////////////
        //////////////////////////////////
        $validator = new Zend_Validate();
		$validator->addValidator(new Zend_Validate_NotEmpty(),true)
				  ->addValidator(new Zend_Validate_StringLength(20),true);

		
		if(!$validator->isValid($arrParam['sign'])){
			$message = $validator->getMessages();
			$this->_messageError['sign'] = 'Sign: ' . current($message);
			$arrParam['sign'] = '';
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
           $this->_arrData['user_avatar'] = $this->uploadFile();
       }
            return $this->_arrData;
    }
    
    public function uploadFile(){
        $upload_dir = FILES_PATH . '/users';
        
        $upload = new Zendda_File_Upload();
        $fileInfo = $upload->getFileInfo('user_avatar');
		$fileName = $fileInfo['user_avatar']['name'];
		
		if(!empty($fileName)){
            $fileName = $upload->upload($fileName, $upload_dir . '/orignal',array('task'=>'rename'),'user_');
            
            $thumb = Zendda_File_Images::create($upload_dir . '/orignal/' . $fileName);
    		$thumb->resize(100,100)->save($upload_dir . '/img100x100/' . $fileName);
    
    		$thumb = Zendda_File_Images::create($upload_dir . '/orignal/' . $fileName);
    		$thumb->resize(450,450)->save($upload_dir . '/img450x450/' . $fileName);
		    if($this->_arrData['action']=='edit'){
		        $upload->removeFile($upload_dir . '/orignal/' . $this->_arrData['current_user_avatar']);
		        $upload->removeFile($upload_dir . '/img100x100/' . $this->_arrData['current_user_avatar']);
		        $upload->removeFile($upload_dir . '/img450x450/' . $this->_arrData['current_user_avatar']);
		    }
		}else{
		    if($this->_arrData['action']=='edit'){
		        $fileName = $this->_arrData['current_user_avatar'];
		    }
		}
		
		return $fileName;
    }
}