<?php
class Zendda_System_Acl {
	
	protected $_acl;
	protected $_role;
	public function __construct($aclInfo = null, $options = null) {
		if (! empty ( $aclInfo )) {
			$acl = new Zend_Acl ();
			$this->_role = $aclInfo ['role'];
			$groupPrivileges = $aclInfo ['privileges'];
			$acl->addRole ( new Zend_Acl_Role ( $this->_role ) );
			$acl->allow ( $this->_role, null, $groupPrivileges );
			$this->_acl = $acl;
		}
	}
	
	public function isAllowed($arrParam = null) {
		$privilege = $arrParam ['module'] . '_' . $arrParam ['controller'] . '_' . $arrParam ['action'];
		$flagAccess = false;
		if ($this->_acl->isAllowed ( $this->_role, null, $privilege )) {
			$flagAccess = true;
		}
		return $flagAccess;
	}
	
	public function createPrivilegeArray($option = null) {
		$ns = new Zend_Session_Namespace ( 'info' );
		$nsInfo = $ns->getIterator ();
		$info = $nsInfo ['member'];
		$group_id = $info ['group_id'];
		$db = Zend_Registry::get ( 'connectDb' );
		$select = $db->select ()->from ( 'da_privileges as p' )->join ( 'da_user_group_privileges as gp', 'p.id = gp.privilege_id' )->where ( 'status = 1' )->where ( 'group_id = ?', $group_id, INTEGER );
		$result = $db->fetchAll ( $select );
		if (! empty ( $result )) {
			$arrPrivileges = array ();
			foreach ( $result as $key ) {
				$arrPrivilege [] = $key ['module'] . '_' . $key ['controller'] . '_' . $key ['action'];
			}
		}
		$ns->acl ['privileges'] = $arrPrivilege;
	}
	
	public function createRole($option = null) {
		$ns = new Zend_Session_Namespace ( 'info' );
		$nsInfo = $ns->getIterator ();
		$info = $nsInfo ['group'];
		$group_name = $info ['group_name'];
		$ns->acl ['role'] = $group_name;
	}
}