<?php
/**
 * Smarty {inarray} modifier plugin
 *
 * Type:     modifier<br/>
 * Name:     inarray<br/>
 * Purpose:  handle array member checking in template<br/>
 * @author   Randy Grafton <rgrafton at kanaitek dot com>
 * @param int $needle value being sought
 * @param array $haystack group of values being queried
 * @return boolean
 */
function smarty_modifier_inarray($haystack, $needle)
{
	if(empty($haystack))
		return false;
	else
		return in_array($needle, $haystack);
}
?>