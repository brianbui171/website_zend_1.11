<?php
class Donga_Form_ValidateAlbum{
    
    //CHUA NHUNG THONG BAO LOI CUA FORM
    protected $_messageError = null;
    
    //MANG CHUA DU LIEU SAU KHI KIEM TRA
    protected $_arrData;
    
    public function __construct($arrParam = array(),$options = null){
        
        //////////////////////////////////
        //Kiem tra Name /////////////
        //////////////////////////////////
        if($arrParam['action'] == 'add'){
            $options = array('table'=>'da_album','field'=>'album_name');
        }elseif ($arrParam['action'] == 'edit'){
            $options = array('table'=>'da_album',
            				 'field'=>'album_name',
            				 'exclude' => array('field'=>'id',
												'value'=> $arrParam['id']
								)
							);
        }
        
       $validator = new Zend_Validate(); 
       $validator->addValidator(new Zend_Validate_NotEmpty(),true)
                  ->addValidator(new Zend_Validate_StringLength(3,100),true);
        
        if(!$validator->isValid($arrParam['album_name'])){
            $message = $validator->getMessages();
            $this->_messageError['album_name'] =  'Tên album: ' . current($message);
            $arrParam['album_name'] = '';
        }

        //////////////////////////////////
        //Kiem tra Picture small ///////////
        //////////////////////////////////
       $upload = new Zend_File_Transfer_Adapter_Http();
	   $fileInfo = $upload->getFileInfo('picture');
		
		$fileName = $fileInfo['picture']['name'];
		
		if(!empty($fileName)){
		
			$upload->addValidator('Extension',true,array('jpg','gif','png'),'picture');
			$upload->addValidator('Size',true,array('min'=>'2KB','max'=>'1000KB'),'picture');
			if(!$upload->isValid('picture')){
				$message = $upload->getMessages();
				$this->_messageError['picture'] = 'Hình ảnh đại diện: ' . current($message);
				
			}
		}
	
        //////////////////////////////////
        //Kiem tra Order /////////////
        //////////////////////////////////
        $validator = new Zend_Validate();
        $validator->addValidator(new Zend_Validate_StringLength(1,10),true)
                  ->addValidator(new Zend_Validate_Digits(),true);
        if(!$validator->isValid($arrParam['order'])){
            $message = $validator->getMessages();
            $this->_messageError['order'] = 'Sắp xếp: ' . current($message);
            $arrParam['order'] = '';
        }
             
        //////////////////////////////////
        //Kiem tra Status /////////////
        //////////////////////////////////
        if(empty($arrParam['status']) || !isset($arrParam['status'])){
			$arrParam['status'] = 0;
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
           $this->_arrData['picture'] = $this->uploadFile();
       }
            return $this->_arrData;
    }
    
    public function uploadFile(){
        $upload_dir = FILES_PATH . '/photo';
        
        $upload = new Zendda_File_Upload();
        $fileInfo = $upload->getFileInfo('picture');
		$fileName = $fileInfo['picture']['name'];
		
		if(!empty($fileName)){
            $fileName = $upload->upload($fileName, $upload_dir . '/album',array('task'=>'rename'),'album_');
            
            $thumb = Zendda_File_Images::create($upload_dir . '/album/' . $fileName);
    		//$thumb->resize(200,200)->save($upload_dir . '/album/' . $fileName);
    		$thumb->save($upload_dir . '/album/' . $fileName);
    		
		    if($this->_arrData['action']=='edit'){
		        $upload->removeFile($upload_dir . '/album/' . $this->_arrData['current_item_picture']);
		    }
		}else{
		    if($this->_arrData['action']=='edit'){
		        $fileName = $this->_arrData['current_item_picture'];
		    }
		}
		
		return $fileName;
    }
}