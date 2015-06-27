<?php
class Donga_UploadController extends Zendda_Controller_Action{
    
    //Mang tham so nhan dc o moi Action
    protected $_arrParams;
    
    //Duong dan cua Controller
    protected $_currentController;
    
    //Duong dan cua Action chay chinh
    protected $_mainAction; 
    
    public function uploadImageAction(){
    	$this->_helper->layout->disableLayout();
           $this->_helper->viewRenderer->setNoRender();
        	if (!empty($_FILES)) {
        	$tempFile = $_FILES['Filedata']['tmp_name'];
        	//$targetPath = FILES_PATH . '/photo/album-dtl';
        	// Validate the file type
        	$fileTypes = array('jpg','jpeg','gif','png','JPG','JPEG','GIF','PNG'); // File extensions
        	$fileParts = pathinfo($_FILES['Filedata']['name']);
            //$newName = "album_" . time ();
        	//$targetFile = rtrim($targetPath,'/') . '/'.$newName .'.'. $fileParts['extension'];
            
        	if (in_array($fileParts['extension'],$fileTypes)) {
        		/*move_uploaded_file($tempFile,$targetFile);
        		echo $newName .'.'. $fileParts['extension'];*/
        		
        		$upload_dir = FILES_PATH . '/photo';
        
		        $upload = new Zendda_File_Upload();
				$fileName = $_FILES['Filedata']['name'];
				
				if(!empty($fileName)){
		            $fileName = $upload->upload($fileName, $upload_dir . '/album-dtl',array('task'=>'rename'),'album_');
		            
		            $thumb = Zendda_File_Images::create($upload_dir . '/album-dtl/' . $fileName);
		    		$thumb->resize(200,200)->save($upload_dir . '/album-dtl/thumbnails/' . $fileName);    		
				}
				echo $fileName;
        	} else {
        		echo 'Invalid file type.';
        	}        	
         }
    } 
}