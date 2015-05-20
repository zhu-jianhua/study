<!-- Listing 38-2: A server-side browser sniff (browsersniff.php) -->
<?php
if (strpos($HTTP_USER_AGENT, 'MSIE') > 0) {
  header("Location: index_ie.html");
} elseif (strpos($HTTP_USER_AGENT, 'Gecko') > 0) {
  header("Location: index_moz.html");
}
?>
