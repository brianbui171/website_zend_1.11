<?php
class Zendda_View_Helper_CmsSelect extends Zend_View_Helper_Abstract {
	
	public function cmsSelect($name, $value = null, $options, $attribs = array()) {
		$strAttribs = '';
		if (count ( $attribs ) > 0) {
			foreach ( $attribs as $keyAttribs => $valueAttribs ) {
				$strAttribs .= $keyAttribs . '="' . $valueAttribs . '" ';
			}
		}
		
		$xhtml = '<select name="' . $name . '" id="' . $name . '" ' . $strAttribs . ' >';
		
		foreach ( $options as $key => $info ) {
			$strSelect = '';
			if ($info ['category_id'] == $value) {
				$strSelect = 'selected="selected"';
			}
			
			if ($info ['level'] == 1) {
				$xhtml .= '<option value="' . $info ['category_id'] . '" ' . $strSelect . '>+ ' . $info ['category_name'] . '</option>';
			} else {
				$string = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				$newString = '';
				for($i = 1; $i < $info ['level']; $i ++) {
					$newString .= $string;
				}
				$info ['category_name'] = $newString . '- ' . $info ['category_name'];
				$xhtml .= '<option value="' . $info ['category_id'] . '" ' . $strSelect . '>' . $info ['category_name'] . '</option>';
			}
		}
		
		$xhtml .= '</select>';
		
		return $xhtml;
	}
}