<?php
class Zendda_Encode {
	
	public function password($value) {
		$newPass = md5 ( $value );
		return $newPass;
	}
}