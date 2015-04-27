<?php
# URL地址栏输入test.php?var1=somevalue&var2=anothervalue
# Output: 
# var1: somevalue
	echo "var1: ", $_GET['var1'], "<br />";
	
# var2: anothervalue	
	echo "var2: ", $_GET['var2'], "<br />";