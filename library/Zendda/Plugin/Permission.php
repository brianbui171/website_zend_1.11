<?php
class Zendda_Plugin_Permission extends Zend_Controller_Plugin_Abstract {
	
	public function preDispatch(Zend_Controller_Request_Abstract $request) {
		
		$auth = Zend_Auth::getInstance ();
		$controllerName = $this->_request->getControllerName ();
		
		if ($controllerName != 'training') {
			$flagAdmin = false;
			$tmp = explode ( '-', $controllerName );
			if ($tmp [0] == 'admin') {
				$flagAdmin = true;
			}
			$flagPage = 'none';
			
			//----------START-KIEM TRA QUYEN TRUY CAP VAO ADMIN -------------
			if ($flagAdmin == true) {
				if ($auth->hasIdentity () == false) {
					$flagPage = 'login';
				} else {
					$info = new Zendda_System_Info ();
					$group_acp = $info->getGroupInfo ( 'group_acp' );
					if ($group_acp != 1) {
						$flagPage = 'no-access';
					} else {
						$aclInfo = $info->getAclInfo ();
						$acl = new Zendda_System_Acl ( $aclInfo );
						$permission = $info->getGroupInfo ( 'permission' );
						if ($permission != 'Full Access') {
							$arrParam = $this->_request->getParams ();
							if ($acl->isAllowed ( $arrParam ) == false) {
								$flagPage = 'no-access';
							}
						}
					}
				}
			}
			//----------END-KIEM TRA QUYEN TRUY CAP VAO ADMIN -------------
			if ($flagPage != 'none') {
				if ($flagPage == 'login') {
					$this->_request->setModuleName ( 'default' );
					$this->_request->setControllerName ( 'public' );
					$this->_request->setActionName ( 'login' );
				}
				
				if ($flagPage == 'no-access') {
					$this->_request->setModuleName ( 'default' );
					$this->_request->setControllerName ( 'public' );
					$this->_request->setActionName ( 'no-access' );
				}
			}
		
		}
	}
}