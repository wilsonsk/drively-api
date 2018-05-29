<?php
/**
 * Smarty {keyexists} modifier plugin
 *
 * Type:     modifier<br/>
 * Name:     keyexists<br/>
 * Purpose:  verify if a key is in an array<br/>
 * @author   Randy Grafton <rgrafton at kanaitek dot com>
 * @param array $array group of values being queried
 * @param int $key value being sought
 * @return boolean
 */
function smarty_modifier_keyexists($array, $key)
{
	if(empty($array) || ! is_array($array))
		return false;
	else
		return array_key_exists($key, $array);
}
?>