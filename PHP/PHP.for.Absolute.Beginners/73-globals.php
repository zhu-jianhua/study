<?php
$foo = "Some value.";

function tests()
{
	echo $GLOBALS['foo'];
}

tests();