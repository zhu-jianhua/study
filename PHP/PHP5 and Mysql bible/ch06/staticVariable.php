<?php
function SayMyABCs3() {
	static $count;
	$limit = $count + 10;
	while ($count < $limit) {
		print(chr(ord('A') + $count));
		$count = $count + 1;
	}
	print ("<BR>Now I know $count letters<BR>");
}
$count = 0;
SayMyABCs3();
$count = $count + 1;
print("Now I've made $count function call(s).<BR>");
SayMyABCs3();
$count = $count + 1;
print("Now I've made $count function call(s).<BR>");