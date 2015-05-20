<?php
  function error_msg($err_type, $err_msg, $err_file, $err_line)
  {
    echo "<div class='errorMsg'>";
    echo "<b>Error:</b>";
    echo "<p>";
    echo "We're sorry, but an error has occurred " .
      "in this page. ";
    echo "Please access the <a href='/help.html'>Help" .
      "</a> page, ";
    echo "or try again later.";
    echo "</div>";
    echo "<div class='finePrint'>";
    echo "Error type: $err_type: $err_msg in $err_file " .
      "at line $err_line";
    echo "</div>";
  }
?>
