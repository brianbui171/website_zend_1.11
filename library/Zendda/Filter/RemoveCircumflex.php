<?php
class Zendda_Filter_RemoveCircumflex implements Zend_Filter_Interface {
	
	public function filter($value) {
		/*a Ă  áº£ Ă£ Ă¡ áº¡ Äƒ áº± áº³ áºµ áº¯ áº· Ă¢ áº§ áº© áº« áº¥ áº­ b c d Ä‘ e Ă¨ áº» áº½ Ă© áº¹ Ăª á»� á»ƒ á»… áº¿ á»‡ 
		f g h i Ă¬ á»‰ Ä© Ă­ á»‹ j k l m n o Ă² á»� Ăµ Ă³ á»� Ă´ á»“ á»• á»— á»‘ á»™ Æ¡ á»� á»Ÿ á»¡ á»› á»£ 
		p q r s t u Ă¹ á»§ Å© Ăº á»¥ Æ° á»« á»­ á»¯ á»© á»± v w x y á»³ á»· á»¹ Ă½ á»µ z*/
		
		$charaterA = '#(Ă |áº£|Ă£|Ă¡|áº¡|Äƒ|áº±|áº³|áºµ|áº¯|áº·|Ă¢|áº§|áº©|áº«|áº¥|áº­)#imsU';
		$repleceCharaterA = 'a';
		$value = preg_replace ( $charaterA, $repleceCharaterA, $value );
		
		$charaterD = '#(Ä‘)#imsU';
		$replaceCharaterD = 'd';
		$value = preg_replace ( $charaterD, $replaceCharaterD, $value );
		
		$charaterD = '#(Ă¨|áº»|áº½|Ă©|áº¹|Ăª|á»�|á»ƒ|á»…|áº¿|á»‡)#imsU';
		$replaceCharaterD = 'e';
		$value = preg_replace ( $charaterD, $replaceCharaterD, $value );
		
		$charaterI = '#(Ă¬|á»‰|Ä©|Ă­|á»‹)#imsU';
		$replaceCharaterI = 'i';
		$value = preg_replace ( $charaterI, $replaceCharaterI, $value );
		
		$charaterO = '#(Ă²|á»�|Ăµ|Ă³|á»�|Ă´|á»“|á»•|á»—|á»‘|á»™|Æ¡|á»�|á»Ÿ|á»¡|á»›|á»£)#imsU';
		$replaceCharaterO = 'o';
		$value = preg_replace ( $charaterO, $replaceCharaterO, $value );
		
		$charaterU = '#(Ă¹|á»§|Å©|Ăº|á»¥|Æ°|á»«|á»­|á»¯|á»©|á»±)#imsU';
		$replaceCharaterU = 'u';
		$value = preg_replace ( $charaterU, $replaceCharaterU, $value );
		
		$charaterY = '#(á»³|á»·|á»¹|Ă½)#imsU';
		$replaceCharaterY = 'y';
		$value = preg_replace ( $charaterY, $replaceCharaterY, $value );
		
		return $value;
	}
}