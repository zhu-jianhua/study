<?php
error_reporting(E_ALL);

$foo = "I'm outside the function!";

function tests()
{
	# Declare $foo as a global variable
	global $foo;
	return $foo;
}

# A notice is issued that $foo is undefined
echo tests();