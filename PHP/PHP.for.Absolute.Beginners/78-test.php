<?php
error_reporting(E_ALL);

$foo = "This is a comple value & it needs to be URL-encoded.";

# Output the original string
echo $foo, "<br /><br />";

# URL encode the string
$bar = urlencode($foo);

# Output the URL-encoded string
echo $bar, "<br /><br />";

# Decode the string and output
echo urldecode($bar);