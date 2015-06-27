<?php
class Zendda_System_Info {
	
	//Ham khoi tao cua lop
	public function __construct() {
		$ns = new Zend_Session_Namespace ( 'info' );
		$ns->setExpirationSeconds ( 7200 );
	}
	
	//Tao thong tin nguoi dang nhap
	public function createInfo() {
		$auth = Zend_Auth::getInstance ();
		$infoAuth = $auth->getIdentity ();
		$this->setMemberInfo ( $infoAuth );
		$this->setGroupInfo ( $infoAuth );
		$this->setAclInfo ();
	}
	
	//Huy thong tin nguoi dang nhap
	public function destroyInfo() {
		$ns = new Zend_Session_Namespace ( 'info' );
		$ns->unsetAll ();
	}
	
	//Thiet lap thong tin user
	public function setMemberInfo($infoAuth, $options = null) {
		$db = Zend_Registry::get ( 'connectDb' );
		$select = $db->select ()->from ( 'da_users' )->where ( 'id = ?', $infoAuth->id, INTEGER );
		
		$result = $db->fetchRow ( $select );
		
		$ns = new Zend_Session_Namespace ( 'info' );
		$ns->member = $result;
	
	}
	
	public function getMemberInfo($part = null) {
		$ns = new Zend_Session_Namespace ( 'info' );
		$nsInfo = $ns->getIterator ();
		
		if ($part == null) {
			$info = $nsInfo ['member'];
		} else {
			$info = $nsInfo ['member'];
			$info = $info [$part];
		}
		
		return $info;
	}
	
	//Thiet lap thong tin phan quyen
	public function setAclInfo() {
		$acl = new Zendda_System_Acl ();
		$acl->createPrivilegeArray ();
		$acl->createRole ();
	}
	
	public function getAclInfo($part = null) {
		$ns = new Zend_Session_Namespace ( 'info' );
		$nsInfo = $ns->getIterator ();
		
		if ($part == null) {
			$info = $nsInfo ['acl'];
		} else {
			$info = $nsInfo ['acl'];
			$info = $info [$part];
		}
		
		return $info;
	}
	
	//Thiet lap thong tin nhom cua user
	public function setGroupInfo($infoAuth) {
		$db = Zend_Registry::get ( 'connectDb' );
		$select = $db->select ()->from ( 'da_user_group' )->where ( 'id = ?', $infoAuth->group_id, INTEGER );
		
		$result = $db->fetchRow ( $select );
		$ns = new Zend_Session_Namespace ( 'info' );
		$ns->group = $result;
	}
	public function getGroupInfo($part = null) {
		$ns = new Zend_Session_Namespace ( 'info' );
		$nsInfo = $ns->getIterator ();
		
		if ($part == null) {
			$info = $nsInfo ['group'];
		} else {
			$info = $nsInfo ['group'];
			$info = $info [$part];
		}
		
		return $info;
	}
	
	public function getInfo() {
		$ns = new Zend_Session_Namespace ( 'info' );
		$info = $ns->getIterator ();
		return $info;
	}

}