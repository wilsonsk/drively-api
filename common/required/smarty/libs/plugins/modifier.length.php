<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     modifier.length.php
 * Type:     modifier
 * Name:     length
 * Purpose:  print the length of a string
 * -------------------------------------------------------------
 */
function smarty_modifier_length($string)
{
    return strlen($string);
}
?>