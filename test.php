<?php
echo "1) " . dirname("/etc/passwd") . PHP_EOL; // 1) /etc
echo "2) " . dirname("/etc/") . PHP_EOL; // 2) / (or \ on Windows)
echo "3) " . dirname("."); // 3) .
?>