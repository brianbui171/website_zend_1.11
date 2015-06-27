<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {
	
	protected function _initSession() {
		Zend_Session::start ();
	}
	
	protected function _initLocale() {
		$locale = new Zend_Locale ( 'vi_VN' );
		Zend_Registry::set ( 'Zend_Locale', $locale );
	}
	
	protected function _initDb() {
		
		$optionResources = $this->getOption ( 'resources' );
		$dbOption = $optionResources ['db'];
		$dbOption ['params'] ['username'] = "YOUR_USER_NAME";
		$dbOption ['params'] ['password'] = "YOUR_PASSWORD";
		$dbOption ['params'] ['dbname'] = "YOUR_DB_NAME";
		
		$adapter = $dbOption ['adapter'];
		$config = $dbOption ['params'];
		$db = Zend_Db::factory ( $adapter, $config );
		$db->setFetchMode ( Zend_Db::FETCH_ASSOC );
		$db->query ( "SET NAMES 'utf8'" );
		$db->query ( "SET CHARACTER SET 'utf8'" );
		Zend_Registry::set ( 'connectDb', $db );
		
		Zend_Db_Table::setDefaultAdapter ( $db );
		
		return $db;
	}
	
	protected function _initFrontcontroller(){
            $front = Zend_Controller_Front::getInstance();
            $front->addModuleDirectory(APPLICATION_PATH . '/modules');
            $front->setDefaultModule('default');
            
            $error = new Zend_Controller_Plugin_ErrorHandler(array('module'=>'default',
            													   'controller'=>'public',
                                                                   'action'=>'error'));
            $front->registerPlugin($error);
            
            $front->registerPlugin(new Zendda_Plugin_Permission());
            
            return $front;
        }
}
    
    
    
    
    
    