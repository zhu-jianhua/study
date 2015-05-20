<?php
function SayMyABCs() {
	$count = 0;
	while ($count < 10) {
		print(chr(ord('A') + $count));
		$count = $count + 1;
	}
	print("<BR>Now I know $count letters<BR>");
}
$count = 0;
SayMyABCs();
$count = $count + 1;
print("Now I've made $count function call(s).<BR>");
SayMyABCs();
$count = $count + 1;
print("Now I’ve made $count function call(s).<BR>");