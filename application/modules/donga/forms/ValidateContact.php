<?php
class Donga_Form_ValidateContact{
    
    //CHUA NHUNG THONG BAO LOI CUA FORM
    protected $_messageError = null;
    
    //MANG CHUA DU LIEU SAU KHI KIEM TRA
    protected $_arrData;
    
    public function __construct($arrParam = array(),$options = null){
        
    	$validateNotEmpty = new Zend_Validate_NotEmpty();
    	$validateNotEmpty->setMessage('Không được để trống.');
    	
        //////////////////////////////////
        //Kiem tra fullname /////////////
        //////////////////////////////////   
        
       $validateStrLength = new Zend_Validate_StringLength(3,100);
	   $validateStrLength->setMessage('Giá trị nhập vào không hợp lệ, giá trị nhập vào là một chuỗi.', 'stringLengthInvalid');
       $validateStrLength->setMessage("Chuỗi nhập vào phải lớn hơn %min% ký tự.", 'stringLengthTooShort');
       $validateStrLength->setMessage("Chuỗi nhập vào phải nhỏ hơn %max% ký tự.", 'stringLengthTooLong');    
       
       $validator = new Zend_Validate(); 
       $validator->addValidator($validateNotEmpty, true)
                  ->addValidator($validateStrLength,true);
        
        if(!$validator->isValid($arrParam['fullname'])){
            $message = $validator->getMessages();
            $this->_messageError['fullname'] =  'Họ và tên: ' . current($message);
            $arrParam['fullname'] = '';
        }   
        
        //////////////////////////////////
        //Kiem tra email /////////////
        //////////////////////////////////  
       
       $validateEmail = new Zend_Validate_EmailAddress();
       $validateEmail->setMessage('Không hợp lệ, Giá trị nhập vào nên là chuỗi.','emailAddressInvalid');
       $validateEmail->setMessage("'%value%' không đúng định dạng email.Email có dạng 'local-part@hostname'",'emailAddressInvalidFormat');
       $validateEmail->setMessage("'%value%' không đúng định dạng email.Email có dạng 'local-part@hostname'",'emailAddressInvalidHostname');
       
       $validator = new Zend_Validate(); 
       $validator->addValidator($validateNotEmpty, true)
                  ->addValidator($validateEmail,true);
        
        if(!$validator->isValid($arrParam['email'])){
            $message = $validator->getMessages();
            $this->_messageError['email'] =  'Địa chỉ Email: ' . current($message);
            $arrParam['email'] = '';
        }   
        
        //////////////////////////////////
        //Kiem tra title /////////////
        //////////////////////////////////       
       $validator = new Zend_Validate(); 
       $validator->addValidator($validateNotEmpty, true)
                  ->addValidator($validateStrLength,true);
        
        if(!$validator->isValid($arrParam['title'])){
            $message = $validator->getMessages();
            $this->_messageError['title'] =  'Tiêu đề ' . current($message);
            $arrParam['title'] = '';
        }   
        
        //////////////////////////////////
        //Kiem tra Content /////////////
        //////////////////////////////////
        $validateStrLengthMsg = new Zend_Validate_StringLength(20);
	    $validateStrLengthMsg->setMessage('Giá trị nhập vào không hợp lệ, giá trị nhập vào là một chuỗi.', 'stringLengthInvalid');
        $validateStrLengthMsg->setMessage("Chuỗi nhập vào phải lớn hơn %min% ký tự.", 'stringLengthTooShort');
        $validateStrLengthMsg->setMessage("Chuỗi nhập vào phải nhỏ hơn %max% ký tự.", 'stringLengthTooLong');
         
        $validator = new Zend_Validate();
		$validator->addValidator($validateNotEmpty, true)
				  ->addValidator($validateStrLengthMsg,true);
				  
		if(!$validator->isValid($arrParam['message'])){
			$message = $validator->getMessages();
			$this->_messageError['message'] = 'Nội dung: ' . current($message);
			$arrParam['message'] = '';
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
        return $this->_arrData;
    }    
}