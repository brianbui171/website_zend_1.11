<?php
class Zendda_View_Helper_CmsEditor extends Zend_View_Helper_Abstract {
	
	public function cmsEditor($name, $value, $options = null, $width = '100%', $height = '350') {
		//1. Nhung tap tin fckeditor vao file chay
		require_once (SCRIPTS_PATH . "/fckeditor/fckeditor_php5.php");
		
		//2. Khai bao duong dan URL den thu muc fckeditor
		$sBasePath = SRCIPTS_URL . '/fckeditor/';
		
		//3. Khoi tao doi tuong FCKeditor
		$oFCKeditor = new FCKeditor ( $name );
		
		//4. Thiet lap duong den cho thuong BasePath
		$oFCKeditor->BasePath = $sBasePath;
		
		//Dua gia tri vao Editor
		$oFCKeditor->Value = $value;
		
		//Thay doi kich thuoc cua Editor
		$oFCKeditor->Width = $width;
		$oFCKeditor->Height = $height;
		
		if (! isset ( $options ['toolbar'] )) {
			$oFCKeditor->ToolbarSet = 'Default';
		} else {
			$oFCKeditor->ToolbarSet = $options ['toolbar'];
		}
		
		if (! isset ( $options ['language'] )) {
			$oFCKeditor->Config ['AutoDetectLanguage'] = false;
			$oFCKeditor->Config ['DefaultLanguage'] = 'en';
		} else {
			$oFCKeditor->Config ['AutoDetectLanguage'] = false;
			$oFCKeditor->Config ['DefaultLanguage'] = $options ['language'];
		}
		
		//5. Tao FCKeditor
		return $oFCKeditor->Create ();
	}
}