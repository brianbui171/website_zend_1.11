<?php
class Zendda_View_Helper_CmsLinkSort extends Zend_View_Helper_Abstract {
	
	public function cmsLinkSort($label, $column, $ssFilter, $imgLink, $actionLink, $defaultOrder = 'DESC') {
		
		if ($ssFilter ['col'] != $column) {
			$linkOrder = $actionLink . '/col/' . $column . '/by/' . $defaultOrder;
			$xhtml = '<a href="' . $linkOrder . '" title = "Sort Z-A">' . $label . ' <br>
                 </a>';
		} else {
			if ($ssFilter ['order'] == 'DESC') {
				$sortOrder = 'ASC';
				$iconSort = $imgLink . '/arrow_down.png';
				$title = 'Sort A-Z';
			} else {
				$sortOrder = 'DESC';
				$iconSort = $imgLink . '/arrow_up.png';
				$title = 'Sort Z-A';
			}
			
			$linkOrder = $actionLink . '/col/' . $column . '/by/' . $sortOrder;
			
			$xhtml = '<a href="' . $linkOrder . '" title = "' . $title . '">' . $label . ' <br>
                    <img src="' . $iconSort . '">
                 </a>';
		}
		
		return $xhtml;
	}
}